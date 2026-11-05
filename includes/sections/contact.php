<?php
// The email is printed as HTML entities so simple scrapers can't read it from the page source.
$email = $cfg['email'] ?? 'hanselluis0809@gmail.com';
$safe  = implode('', array_map(fn($c) => '&#' . ord($c) . ';', str_split($email)));
?>
<section id="contact">
  <div class="wrap wrap--narrow contact">
    <h2 class="section-title">Contact Me</h2>
    <p class="section-sub">Want to talk about a project or just say hi? Send me an email.</p>
    <p class="contact__mail"><i class="fa-regular fa-envelope"></i> <a href="mailto:<?= $safe ?>"><?= $safe ?></a></p>
    <button type="button" class="btn btn--sm" data-copy="<?= $safe ?>">Copy email</button>
    <p class="form__status" data-copy-status role="status"></p>
  </div>
</section>
