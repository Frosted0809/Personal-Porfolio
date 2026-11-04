<?php
// All your content lives here. Edit this file, not the HTML.
return [
    'name'    => 'Hansel Luis Protacio',
    'short'   => 'Hansel Protacio',
    'role'    => 'Information Technology Student',
    'bio'     => 'I build for the web, play CTFs, and I am learning PHP, Python and Java.',
    'photo'   => 'assets/img/hanspic.jpg',
    'github'  => 'https://github.com/Frosted0809',
    'social'  => [
        ['GitHub',   'https://github.com/Frosted0809', 'fa-brands fa-github'],
        ['LinkedIn', 'https://www.linkedin.com/in/protacio-hansel-luis-n-431ba2362/', 'fa-brands fa-linkedin'],
    ],
    'nav'     => ['about' => 'About', 'experience' => 'Experience', 'achievements' => 'Achievements', 'projects' => 'Projects', 'contact' => 'Contact'],

    // Experience = what you can DO + proof. "since" is context, not the headline.
    // Levels: Learning < Foundational < Comfortable < Strong (be honest, it builds trust)
    'experience' => [
        ['icon' => 'fa-solid fa-laptop-code', 'title' => 'Frontend development', 'level' => 'Foundational', 'since' => 'Since ~2 years',
         'proof' => 'Built this portfolio and its responsive layout.', 'tags' => ['HTML', 'CSS', 'JavaScript']],
        ['icon' => 'fa-brands fa-php', 'title' => 'PHP', 'level' => 'Learning', 'since' => 'Current subject',
         'proof' => 'This site: includes, config arrays, JSON API, sessions and a validated contact form.', 'tags' => ['PHP', 'JSON', 'Sessions']],
        ['icon' => 'fa-regular fa-flag', 'title' => 'Capture the Flag', 'level' => 'Learning', 'since' => 'Since ~6 months',
         'proof' => 'Took part in Packet Capture: Beneath the Network CTF (Oct 2026).', 'tags' => ['Networking', 'Cybersecurity'], 'link' => '#achievements'],
        ['icon' => 'fa-brands fa-python', 'title' => 'Python', 'level' => 'Foundational', 'since' => 'Since ~2 years',
         'proof' => 'Fundamentals done; working through 100 Days of Python (Angela Yu).', 'tags' => ['Python']],
        ['icon' => 'fa-brands fa-java', 'title' => 'Java', 'level' => 'Foundational', 'since' => 'Since ~2 years',
         'proof' => 'Fundamentals done; now on more advanced topics.', 'tags' => ['Java']],
    ],

    'achievements' => [
        ['title' => 'Packet Capture: Beneath the Network CTF', 'type' => 'Certificate of Participation',
         'issuer' => 'CyberPH', 'date' => '26 Oct 2026',
         'image' => 'assets/img/cyberph-certificate.png', 'alt' => 'CyberPH certificate of participation for Hansel Luis N. Protacio'],
    ],
];
