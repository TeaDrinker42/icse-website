<?php

namespace Icse\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sabre\VObject;

use Icse\PublicBundle\Entity\Event;

class CalendarController extends Controller
{
    private function fetch ($Url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    public function icsPreprocessAction(Request $request)
    {
        $url = $request->query->get('url');
        $remove_regex = $request->query->get('remove');
        $ics_in = $this->fetch($url);

        $vcal = VObject\Reader::read($ics_in);

        foreach($vcal->VEVENT as $ev) {
            if (preg_match($remove_regex, $ev->SUMMARY))
            {
                $vcal->remove($ev);
            }
        }

        $response = new Response($vcal->serialize(),
                            200,
                            [
                                'Cache-Control' => 'private',
                                'Connection' => 'close',
                                'Content-Type' => 'text/calendar; charset=utf-8',
                            ]);
        $response->setExpires(new \DateTime('+15 minutes'));

        return $response;
    }


    public function testAction()
    {
        $vcalendar = new VObject\Component\VCalendar();

        $vcalendar->add('X-WR-CALNAME', 'ICSE Test');
        $vcalendar->add('X-WR-CALDESC', 'ICSE Events Calendar, oh this changes too');
        $vcalendar->add('X-PUBLISHED-TTL', 'PT15M');

        $vcalendar->add('VEVENT', [
            'SUMMARY' => 'Birthday party again',
            'DTSTART' => new \DateTime('2013-09-17 3pm'),
            'DTEND' => new \DateTime('2013-09-17 4pm'),
            'DTSTAMP' => new \DateTime('now', new \DateTimeZone('utc')),
            'LAST-MODIFIED' => new \DateTime('now', new \DateTimeZone('utc')),
            'UID' => '10@www.union.ic.ac.uk/arts/stringensemble',
            'DESCRIPTION' => 'Created at '. (new \DateTime())->format('Y-m-d H:i:s'),
        ]);

        $vcalendar->add('VEVENT', [
            'SUMMARY' => 'Another Thing',
            'DTSTART' => new \DateTime('2013-09-18 10am'),
            'DTEND' => new \DateTime('2013-09-18 1pm'),
            'DTSTAMP' => new \DateTime('now', new \DateTimeZone('utc')),
            'LAST-MODIFIED' => new \DateTime('now', new \DateTimeZone('utc')),
            'UID' => '11@www.union.ic.ac.uk/arts/stringensemble',
            'DESCRIPTION' => 'Created at '. (new \DateTime())->format('Y-m-d H:i:s'),
        ]);


        $response = new Response($vcalendar->serialize(),
                            200,
                            [
                                'Cache-Control' => 'private',
                                'Connection' => 'close',
                                'Content-Type' => 'text/calendar; charset=utf-8',
                            ]);

        $response->setExpires(new \DateTime('+15 minutes'));

        return $response;
    }

    public function membersAction()
    {
        $dm = $this->getDoctrine();
        $rehearsals = $dm->getRepository('IcseMembersBundle:Rehearsal')
                         ->findAll();

        $vcalendar = new VObject\Component\VCalendar();

        $vcalendar->add('X-WR-CALNAME', 'ICSE Members');
        $vcalendar->add('X-WR-CALDESC', 'Imperial College String Ensemble\'s rehearsals and events');
        $vcalendar->add('X-PUBLISHED-TTL', 'PT15M');

        foreach ($rehearsals as $r)
        {
            $title = "ICSE Rehearsal";
            if ($r->getName())
            {
                $title .= ': '. $r->getName();
            }

            $vcalendar->add('VEVENT', [
                'SUMMARY' => $title,
                'DTSTART' => $r->getStartsAt(),
                'DTEND' =>  $r->getEndsAt(),
                'DTSTAMP' => new \DateTime('now', new \DateTimeZone('utc')),
                'LAST-MODIFIED' => $r->getUpdatedAt()->setTimezone(new \DateTimeZone('utc')),
                'UID' =>  'R'.$r->getId().':'.$r->getStartsAt()->format('Ymd\THis').'@www.union.ic.ac.uk/arts/stringensemble',
                'LOCATION' => $r->getLocation() ? $r->getLocation()->getName() : "",
                'DESCRIPTION' => $r->getComments() . "\n\n" . 'Last reloaded at '. (new \DateTime())->format('Y-m-d H:i:s'),
            ]);            
        }

        $response = new Response($vcalendar->serialize(),
                            200,
                            [
                                'Cache-Control' => 'private',
                                'Connection' => 'close',
                                'Content-Type' => 'text/calendar; charset=utf-8',
                            ]);
        $response->setExpires(new \DateTime('+15 minutes'));
        return $response;
    }

}
