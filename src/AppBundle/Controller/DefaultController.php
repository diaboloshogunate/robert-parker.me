<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $lorem = <<<HTML
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc rhoncus, 
    arcu imperdiet eleifend viverra, est dolor laoreet nibh, nec placerat elit urna in dui. 
    In gravida dolor et neque fringilla mattis. Nulla orci tellus, blandit quis orci vel, consequat suscipit enim. 
    Suspendisse potenti. Phasellus risus lectugivenpus opportunityat id, malesuada eget ex. 
    Pellentesque velit metus, sollicitudin eget turpis eu, sagittis vehicula lorem. 
    Sed vulputate luctus ligula vel dapibus. Donec egestas diam et ligula sollicitudin facilisis. 
    Mauris aliquet blandit urna, eget mollis dui gravida at. Praesent venenatis interdum dapibus. 
    Vestibulum luctus vulputate malesuada. Fusce posuere sit amet massa lobortis iaculis. 
    Nam vulputate accumsan elit eget dapibus. 
    Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
HTML;

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'work' => [
                [
                    'title' => 'Yamiko LLC',
                    'position' => 'Owner',
                    'start' => 'June 2012',
                    'end' => 'Current',
                    'description' => <<<HTML
                        <p>
                            Yamiko is my business I use for contract and freelance work. 
                            I primarily work with Word Press sites and long with applications built with Silex and Symfony. 
                            For my clients I offer web hosting services. My servers are stored on Digital Ocean and managed with Puppet.
                        </p>
HTML

                ],
                [
                    'title' => 'Dorey Design Group',
                    'position' => 'FULL STACK DEVELOPER / SYSTEM ADMINISTRATOR',
                    'start' => 'October 2013',
                    'end' => 'April 2015',
                    'description' => <<<HTML
                        <p>
                            I wore many hats at Dorey Design Group. I managed internal servers that host Stash and Confluence. 
                            I also took over management of our staging server. 
                            Every week I held a training to train the other developers on best practices and new skills.
                        </p>
                        <p>
                            I was also responsible for estimating, building, and updating responsive websites based on proposals, RFCs and Photoshop files. 
                            I worked on Drupal, Joomla and Word Press sites along with fixing old custom developed sites. 
                            In addition to the websites I worked on a few web applications with Silex.
                        </p>
HTML

                ],
                [
                    'title' => 'RBL Interactive',
                    'position' => 'Front End Developer',
                    'start' => 'June 2013',
                    'end' => 'September 2013',
                    'description' => <<<HTML
                        <p>
                            At RBL I created responsive html templates from Photoshop and illustrator files. 
                            The templates would be put into CMS Made Simple. 
                            To reduce repetitive work I created an application in Silex that would create a build of static pages and resources from the twig templates.
                        </p>
HTML

                ]
            ],
            'presentations' => [
                [
                    'title' => 'Get started with PHP 7',
                    'location' => 'PDX PHP',
                    'date' => 'February 2016'
                ],
                [
                    'title' => 'Silex, Symfony’s Microframework!',
                    'location' => 'PDX PHP Meetup',
                    'date' => 'June 2015',
                ],
                [
                    'title' => 'A Tour of Silex and Symfony Components',
                    'location' => 'Pacific Northwest Drupal Summit',
                    'date' => 'October-2014',
                ],
                [
                    'title' => 'Introduction to MVC',
                    'location' => 'Clark Community College',
                    'date' => 'June 2013',
                ],
            ],
            'projects' => [
                [
                    'title' => 'Pocket Key',
                    'url' => 'https://www.pocketkey.com/',
                    'image' => $this->get('assets.packages')->getUrl('images/src/pocket-key-2015-09-02.png'),
                    'description' => <<<HTML
                        Pocket Key offers a device to help user make more secure transactions online. 
                        I worked with Dorey Design Group to modify a premium theme purchased from themeforest to match the design in photoshop.
                        
                        My main responsibility was the development of a plugin to handle the pre registrations.
                        The form is a two step form protected with CSRF protection.
                        
                        After submitting the form the data is stored in the database. 
                        The data can be viewed cia the admin menu and includes charts displayed with the google charts API.
                        The data can be exported as a CSV file.
                        
                        The user receives an email when signing up and is given he opportunity to share info about pocket key on various social media platforms.
                        The email content can be changed via the plugins configuration page.
HTML

                ],
                [
                    'title' => 'Two Sisters',
                    'url' => '',
                    'image' => $this->get('assets.packages')->getUrl('images/src/thetwosisters-2015-05-06 18-25-32.png'),
                    'description' => <<<HTML
                        The Two Sisters have two membership based sites and wanted to track membership activity. 
                        I built them a small silex application that would display the total of new members, renewed members, 
                        expired members and would also track conversion rates between the different membership plans. 
                        They have the ability to select a date range and the totals would be compared to the previous time range. 
                        Because they have so many users and the database was denormalized I had to make heavy use of temporary tables to improve performance. 
HTML
                ],
                [
                    'title' => 'Bonsai Mirai',
                    'url' => 'http://bonsaimirai.com/',
                    'image' => $this->get('assets.packages')->getUrl('images/src/bonsaimirai-2015-05-06 17-38-06.png'),
                    'description' => <<<HTML
                        Bonsai Mirai had an incomplete Drupal site that was hard to use and was not responsive. 
                        The site was comprised of many blocks that required them to enter in HTML with the appropriate structure and classes or the site would break. 
                        I installed and configured modules so they can edit the blocks with Wysiwyg editors and removed the need for them to add classes to the HTML nodes. 
                        Additionally I installed modules so they can edit the blocks while on the page. 
                        After that I reorganized the Sass stylesheets and made the site responsive.
HTML

                ],
                [
                    'title' => 'Element Residential',
                    'url' => 'http://element-residential.com/',
                    'image' => $this->get('assets.packages')->getUrl('images/src/element-residential-2015-05-06 18-14-07.png'),
                    'description' => <<<HTML
                        Element Residential needed a site to show off all of their communities that can also create spin off sites for each of their communities. 
                        For each of this spin of sites they need to be able to control the bakcground images, colors and font colors. 
                        To accomplish this I set up a number of pages to redirect to a custom tempalte. 
                        In this template I loaded in twig, grabbed the community data from the database and rendered the appropriate content. 
                        The main site displays the different communities on a map using the Open Layers module. 
HTML

                ],
                [
                    'title' => 'Mark Westcott',
                    'url' => 'http://markwestcottpianist.com/',
                    'image' => $this->get('assets.packages')->getUrl('images/src/markwestcottpianist-2015-05-06 18-20-00.png'),
                    'description' => <<<HTML
                        Mark Westcott was a world renown pianist whose career came to an end due to focal dystonia. 
                        He moved back to his hometown in Portland OR and started teaching. 
                        I built him a website to help him get students and build up his class. 
                        The site is the first website I built and it uses a custom built MVC framework I built while I was in college. 
HTML

                ]
            ],
        ]);
    }
}
