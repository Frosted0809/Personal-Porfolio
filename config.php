<?php
// content lives here. Edit file.
return [
    'name'    => 'Hansel Luis Protacio',
    'short'   => 'Hansel Protacio',
    'role'    => 'Information Technology Student',
    'bio'     => 'I build for the web, play CTFs, and I am learning PHP and Python.',
    'photo'   => 'assets/img/hanspic.jpg',
    'email'   => 'hanselluis0809@gmail.com',
    'github'  => 'https://github.com/Frosted0809',
    'social'  => [
        ['GitHub',   'https://github.com/Frosted0809', 'fa-brands fa-github'],
        ['LinkedIn', 'https://www.linkedin.com/in/protacio-hansel-luis-n-431ba2362/', 'fa-brands fa-linkedin'],
    ],
    'nav'     => ['about' => 'About', 'experience' => 'Experience', 'achievements' => 'Achievements', 'projects' => 'Projects', 'contact' => 'Contact'],

    // Levels: Learning < Foundational < Comfortable < Strong
    'experience' => [
        ['icon' => 'fa-solid fa-laptop-code', 'title' => 'Frontend development', 'level' => 'Foundational', 'since' => 'Since ~2 years',
         'proof' => 'Built this portfolio and its responsive layout.', 'tags' => ['HTML', 'CSS', 'JavaScript']],
        ['icon' => 'fa-brands fa-php', 'title' => 'PHP', 'level' => 'Learning', 'since' => 'Learning through this site',
         'proof' => 'Learning PHP by building this site.', 'tags' => ['PHP', 'JSON', 'APIs']],
        ['icon' => 'fa-brands fa-microsoft', 'title' => 'C# / ASP.NET Core', 'level' => 'Foundational', 'since' => 'Project experience',
         'proof' => 'Built the DiagnoSys API with ASP.NET Core 8, Entity Framework Core, SQL Server, AutoMapper, Swagger and a layered architecture.', 'tags' => ['C#', 'ASP.NET Core', 'REST APIs', 'SQL Server']],
        ['icon' => 'fa-solid fa-network-wired', 'title' => 'Networking / Cisco Packet Tracer', 'level' => 'Foundational', 'since' => 'Course experience',
         'proof' => 'Completed Cisco Networking Academy\'s Introduction to Packet Tracer course and earned a verified Credly badge.', 'tags' => ['Networking', 'Cisco Packet Tracer']],
        ['icon' => 'fa-regular fa-flag', 'title' => 'Capture the Flag', 'level' => 'Learning', 'since' => 'Since ~6 months',
         'proof' => 'Took part in Packet Capture: Beneath the Network CTF (Oct 2026).', 'tags' => ['Networking', 'Cybersecurity'], 'link' => '#achievements'],
        ['icon' => 'fa-brands fa-python', 'title' => 'Python', 'level' => 'Foundational', 'since' => 'Since ~2 years',
         'proof' => 'Fundamentals done; working through 100 Days of Python (Angela Yu).', 'tags' => ['Python']],
    ],

    'achievements' => [
        ['title' => 'Packet Capture: Beneath the Network CTF', 'type' => 'Certificate of Participation',
         'issuer' => 'CyberPH', 'date' => '26 Oct 2026',
         'image' => 'assets/img/cyberph-certificate.png', 'alt' => 'CyberPH certificate of participation for Hansel Luis N. Protacio'],
        ['title' => 'Introduction to Packet Tracer', 'type' => 'Cisco Networking Academy Badge',
         'issuer' => 'Cisco Networking Academy', 'date' => 'Verified on Credly',
         'image' => 'assets/img/introduction-to-packet-tracer.png', 'alt' => 'Verified Cisco Networking Academy Introduction to Packet Tracer badge',
         'description' => 'Completed the Introduction to Packet Tracer course and earned a verified badge.',
         'link' => 'https://www.credly.com/badges/badb6db2-868d-409a-a7cd-efbda1186318/public_url'],
    ],
];
