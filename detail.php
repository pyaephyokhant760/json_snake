<?php
require_once 'includes/functions.php';

// Get the 'id' from the URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Path to the JSON file
$dataFile = './data/user.json';

// Read JSON data
$users = readJSON($dataFile);
if (!is_array($users)) {
    $users = [];
}

// Find the specific user
$user = null;
$position = 0;
foreach ($users as $i => $u) {
    if ((int) ($u['Id'] ?? 0) === $id) { // Match based on 'Id'
        $user = $u;
        $position = $i + 1;
        break;
    }
}

$related = [];
if ($user) {
    $sameGroup = [];
    $others = [];
    foreach ($users as $u) {
        if ((int) ($u['Id'] ?? 0) === $id) {
            continue;
        }
        if (isYes($u['IsDanger'] ?? '') === isYes($user['IsDanger'] ?? '')) {
            $sameGroup[] = $u;
        } else {
            $others[] = $u;
        }
    }
    $related = array_slice(array_merge($sameGroup, $others), 0, 4);
}

$pageTitle = $user ? trim($user['MMName'] ?? '') . ' | မြွေအဘိဓာန်' : 'မတွေ့ပါ | မြွေအဘိဓာန်';
?>

<!DOCTYPE html>
<html lang="my">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Padauk:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="page">
        <header class="topbar">
            <div class="container topbar-inner">
                <a href="index.php" class="brand">
                    <span class="brand-mark">&#128013;</span>
                    <span class="brand-text">
                        <small>Snake Encyclopedia</small>
                        <span>မြွေအဘိဓာန်</span>
                    </span>
                </a>
                <a href="index.php" class="topbar-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h10" />
                    </svg>
                    <span>စာရင်းအားလုံး</span>
                </a>
            </div>
        </header>

        <main class="container">
            <?php if (!$user): ?>
                <div class="notfound">
                    <h1>မြွေ အချက်အလက် မတွေ့ပါ</h1>
                    <p>သင်ရှာနေသော မြွေသည် စာရင်းထဲတွင် မရှိပါ။ စာရင်းသို့ ပြန်သွား၍ ထပ်မံ ရွေးချယ်ကြည့်ပါ။</p>
                    <a class="btn" href="index.php">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H6"></path>
                            <path d="m11 19-7-7 7-7"></path>
                        </svg>
                        စာရင်းသို့ ပြန်သွားရန်
                    </a>
                </div>
            <?php else: ?>
                <?php
                $isPoison = isYes($user['IsPoison'] ?? '');
                $isDanger = isYes($user['IsDanger'] ?? '');
                $mmName = trim($user['MMName'] ?? '');
                $engName = trim($user['EngName'] ?? '');
                ?>
                <div class="detail-head">
                    <a href="index.php" class="back-link">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H6"></path>
                            <path d="m11 19-7-7 7-7"></path>
                        </svg>
                        နောက်သို့
                    </a>
                    <span class="crumb">မြွေများ / <?= e($mmName !== '' ? $mmName : 'အမည်မသိ') ?></span>
                </div>

                <div class="detail-layout">
                    <figure class="media-panel">
                        <img src="<?= e(imageUrl($user['image'] ?? '')) ?>" alt="<?= e($mmName) ?>">
                        <figcaption class="media-caption">
                            <span>ဓာတ်ပုံ — <?= e($mmName) ?></span>
                            <span>#<?= str_pad((string) $position, 2, '0', STR_PAD_LEFT) ?></span>
                        </figcaption>
                    </figure>

                    <article class="info-panel">
                        <h1><?= e($mmName) ?></h1>
                        <?php if ($engName !== ''): ?>
                            <p class="info-en">English Name — <?= e($engName) ?></p>
                        <?php endif; ?>

                        <div class="tags">
                            <span class="tag <?= $isDanger ? 'tag-danger' : 'tag-safe' ?>">
                                <?= $isDanger ? 'အန္တရာယ် ရှိသည်' : 'အန္တရာယ် မရှိပါ' ?>
                            </span>
                            <span class="tag <?= $isPoison ? 'tag-poison' : 'tag-none' ?>">
                                <?= $isPoison ? 'အဆိပ် ပါသည်' : 'အဆိပ် မပါပါ' ?>
                            </span>
                        </div>

                        <h2 class="section-label">အကြောင်းအရာ</h2>
                        <div class="detail-text">
                            <?php foreach (paragraphs($user['Detail'] ?? '') as $line): ?>
                                <p><?= e($line) ?></p>
                            <?php endforeach; ?>
                        </div>

                        <div class="facts">
                            <div class="fact">
                                <span>အဆိပ်</span>
                                <b><?= $isPoison ? 'ပါသည်' : 'မပါပါ' ?></b>
                            </div>
                            <div class="fact">
                                <span>အန္တရာယ်</span>
                                <b><?= $isDanger ? 'ရှိသည်' : 'မရှိပါ' ?></b>
                            </div>
                            <div class="fact">
                                <span>မှတ်တမ်း</span>
                                <b>#<?= str_pad((string) $position, 2, '0', STR_PAD_LEFT) ?></b>
                            </div>
                        </div>
                    </article>
                </div>

                <?php if ($related): ?>
                    <section class="related">
                        <h2 class="section-label">ဆက်စပ် ကြည့်ရှုရန်</h2>
                        <div class="grid">
                            <?php foreach ($related as $item): ?>
                                <?php
                                $rPoison = isYes($item['IsPoison'] ?? '');
                                $rDanger = isYes($item['IsDanger'] ?? '');
                                $rName = trim($item['MMName'] ?? '');
                                $rEng = trim($item['EngName'] ?? '');
                                ?>
                                <article class="card">
                                    <a class="card-media" href="detail.php?id=<?= (int) $item['Id'] ?>" tabindex="-1" aria-hidden="true">
                                        <img src="<?= e(imageUrl($item['image'] ?? '')) ?>" alt="<?= e($rName) ?>" loading="lazy" decoding="async">
                                    </a>
                                    <div class="card-body">
                                        <h3 class="card-title"><?= e($rName) ?></h3>
                                        <?php if ($rEng !== ''): ?>
                                            <p class="card-en"><?= e($rEng) ?></p>
                                        <?php endif; ?>
                                        <div class="tags">
                                            <span class="tag <?= $rDanger ? 'tag-danger' : 'tag-safe' ?>">
                                                <?= $rDanger ? 'အန္တရာယ်ရှိ' : 'အန္တရာယ်မရှိ' ?>
                                            </span>
                                            <span class="tag <?= $rPoison ? 'tag-poison' : 'tag-none' ?>">
                                                <?= $rPoison ? 'အဆိပ်ပါ' : 'အဆိပ်မပါ' ?>
                                            </span>
                                        </div>
                                        <a class="btn" href="detail.php?id=<?= (int) $item['Id'] ?>">ကြည့်ရန်</a>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            <?php endif; ?>

            <footer class="footer">
                <span>&copy; <?= date('Y') ?> မြွေအဘိဓာန် · Snake Encyclopedia</span>
                <span>သတိပေးချက် — မြွေများကို ကိုယ်တိုင် မကိုင်တွယ်ပါနှင့်။</span>
            </footer>
        </main>
    </div>
</body>

</html>