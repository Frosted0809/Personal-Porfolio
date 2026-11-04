<?php $sent = $_GET['sent'] ?? null; ?>
<section id="contact">
  <div class="wrap wrap--narrow">
    <h2 class="section-title">Contact Me</h2>
    <form id="contact-form" class="form" action="api/contact.php" method="post" novalidate>
      <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
      <div class="hp" aria-hidden="true"><label>Leave empty <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
      <label for="email">Email</label>
      <input id="email" name="email" type="email" maxlength="120" placeholder="you@example.com" required>
      <label for="message">Message</label>
      <textarea id="message" name="message" rows="5" maxlength="1000" placeholder="Say hi…" required></textarea>
      <button type="submit" class="btn">Send message</button>
      <p class="form__status" id="form-status" role="status"><?php
        if ($sent === '1') echo 'Thanks! Your message was sent.';
        elseif ($sent === '0') echo 'Something went wrong. Check your email and message, then try again.';
      ?></p>
    </form>
  </div>
</section>
