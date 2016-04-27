<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StyleguideController extends Controller
{

    /**
     * @Route("/styleguide/")
     * @Method({"GET"})
     * @Template("AppBundle:Styleguide:index.html.twig")
     */
    public function styleguideAction()
    {
        return [
            "sgTplDoc" => 'AppBundle:Styleguide/templates:doc.html.twig',
            "sgSections" => [
                [
                    "slug" => "elements",
                    "title" => "Elements",
                    "pages" => [
                        [
                            "slug" => "typography",
                            "title" => "Typography"
                        ],
                        [
                            "slug" => "code",
                            "title" => "Code"
                        ]
                    ]
                ],
                [
                    "slug" => "grid",
                    "title" => "Grid system",
                    "pages" => [
                        [
                            "slug" => "concept",
                            "title" => "Concept"
                        ],
                        [
                            "slug" => "options",
                            "title" =>  "Options"
                        ],
                        [
                            "slug" => "examples",
                            "title" =>  "Examples"
                        ]
                    ]
                ],
                [
                    "slug" => "forms",
                    "title" => "Forms",
                    "pages" => [
                        [
                            "slug" => "bases",
                            "title" => "Bases"
                        ]
                    ]
                ],
                [
                    "slug" => "objects",
                    "title" => "Objects",
                    "pages" => [
                        [
                            "slug" => "paper-sheet",
                            "title" => "Paper sheet"
                        ],
                        [
                            "slug" => "icons",
                            "title" => "Icons"
                        ],
                        [
                            "slug" => "buttons",
                            "title" => "Buttons"
                        ],
                        [
                            "slug" => "alerts",
                            "title" => "Alerts"
                        ],
                        [
                            "slug" => "labels",
                            "title" => "Labels"
                        ],
                        [
                            "slug" => "tables",
                            "title" => "Tables"
                        ],
                        [
                            "slug" => "progress-bar",
                            "title" => "Progress bar"
                        ]
                    ]
                ],
                [
                    "slug" => "components",
                    "title" => "Components",
                    "pages" => [
                        [
                            "slug" => "links-nav",
                            "title" => "Links nav"
                        ],
                        [
                            "slug" => "nice-links-list",
                            "title" => "Nice links list"
                        ]
                    ]
                ],
                [
                    "slug" => "ui-angular",
                    "title" => "UI angular",
                    "pages" => [
                        [
                            "slug" => "drop-to-add",
                            "title" => "Drop to add"
                        ],
                        [
                            "slug" => "click-confirm",
                            "title" => "Click confirm"
                        ],
                        [
                            "slug" => "dropdown",
                            "title" => "Dropdown"
                        ],
                        [
                            "slug" => "tooltips",
                            "title" => "Tooltips"
                        ],
                        [
                            "slug" => "tabs",
                            "title" => "Tabs"
                        ]
                    ]
                ]
            ]
        ];
    }
}
