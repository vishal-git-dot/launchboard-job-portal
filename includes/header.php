<?php $user = current_user(); $flashMessage = take_flash(); $pageTitle = $pageTitle ?? 'Find your next opportunity'; ?>
<!doctype html>
<html lang="en" data-theme="light">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f7f8fc"><title><?= e($pageTitle) ?> · <?= APP_NAME ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css"><script>try{document.documentElement.dataset.theme=localStorage.getItem('launchboard-theme')||'light'}catch(e){}</script>
</head>
<body>
<a class="skip-link" href="#main">Skip to content</a>
<header class="site-header"><div class="nav-wrap">
  <a class="brand" href="index.php" aria-label="Launchboard home"><span class="brand-mark"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 17.5 11.8 4l2.1 6.1 5.1-1.3-7.2 11.1-1.4-6.2z"/></svg></span><span>launchboard<span class="brand-period">.</span></span></a>
  <button class="mobile-menu" aria-label="Toggle navigation" aria-expanded="false"><span></span><span></span></button>
  <nav class="main-nav" aria-label="Main navigation"><a class="nav-link <?= basename($_SERVER['PHP_SELF'])==='jobs.php'?'active':'' ?>" href="jobs.php">Explore jobs</a><?php if ($user && $user['role']==='student'): ?><a class="nav-link <?= basename($_SERVER['PHP_SELF'])==='my_applications.php'?'active':'' ?>" href="my_applications.php">My applications</a><?php endif; ?><?php if ($user && $user['role']==='admin'): ?><a class="nav-link <?= basename($_SERVER['PHP_SELF'])==='admin.php'?'active':'' ?>" href="admin.php">Manage</a><?php endif; ?></nav>
  <div class="nav-actions"><button class="theme-toggle" type="button" aria-label="Switch theme"><span class="theme-icon">☾</span><span class="theme-label">Dark Mode</span></button>
  <?php if ($user): ?><div class="user-chip"><span class="avatar"><?= e(initials($user['name'])) ?></span><span class="user-name"><?= e($user['name']) ?></span></div><a class="button button-quiet button-small" href="logout.php">Sign out</a><?php else: ?><a class="button button-quiet button-small" href="login.php">Sign in</a><a class="button button-primary button-small" href="register.php">Get started <span aria-hidden="true">↗</span></a><?php endif; ?></div>
</div></header>
<?php if ($flashMessage): ?><div class="toast toast-<?= e($flashMessage['type']) ?>" role="status"><span><?= $flashMessage['type']==='success'?'✓':'!' ?></span><?= e($flashMessage['message']) ?><button class="toast-close" aria-label="Dismiss notification">×</button></div><?php endif; ?>
<main id="main">
