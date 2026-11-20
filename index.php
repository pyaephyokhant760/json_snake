<?php
require_once 'includes/functions.php';

// JSON ဖိုင်လမ်းကြောင်း
$dataFile = './data/user.json';

// JSON ဒေတာကိုဖတ်ခြင်း
$users = readJSON($dataFile);
if (!is_array($users)) {
    $users = [];
}

$total = count($users);
$poisonCount = 0;
$dangerCount = 0;
foreach ($users as $u) {
    if (isYes($u['IsPoison'] ?? '')) {
        $poisonCount++;
    }
    if (isYes($u['IsDanger'] ?? '')) {
        $dangerCount++;
    }
}
$safeCount = $total - $dangerCount;
?>

<!DOCTYPE html>
<html lang="my">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>မြန်မာ့မြွေများ | Snake Encyclopedia</title>
    <meta name="description" content="မြန်မာ့မြွေများ၏ အမည်၊ ဓာတ်ပုံ၊ အဆိပ်ပါ/မပါ နှင့် အန္တရာယ်ရှိ/မရှိ အချက်အလက်များ။">
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
                <a href="#collection" class="topbar-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 6h16M4 12h16M4 18h10" />
                    </svg>
                    <span>မြွေများကြည့်ရန်</span>
                </a>
            </div>
        </header>

        <main>
            <section class="container hero">
                <span class="eyebrow"><span class="dot"></span> မြန်မာနိုင်ငံရှိ မြွေမျိုးစိတ် <?= $total ?> မျိုး</span>
                <h1>မြွေတွေအကြောင်း <span class="grad">အလွယ်တကူ</span> လေ့လာပါ</h1>
                <p class="lead">
                    မြွေတစ်ကောင်ချင်းစီ၏ မြန်မာအမည်၊ အင်္ဂလိပ်အမည်၊ အဆိပ်ပါ/မပါ နှင့် အန္တရာယ်ရှိ/မရှိ
                    အချက်အလက်များကို တစ်နေရာတည်းတွင် စုစည်းပေးထားပါသည်။
                </p>

                <div class="stats">
                    <div class="stat">
                        <b><?= $total ?></b>
                        <span>စုစုပေါင်း</span>
                    </div>
                    <div class="stat poison">
                        <b><?= $poisonCount ?></b>
                        <span>အဆိပ်ပါ</span>
                    </div>
                    <div class="stat danger">
                        <b><?= $dangerCount ?></b>
                        <span>အန္တရာယ်ရှိ</span>
                    </div>
                </div>

                <div class="controls">
                    <div class="search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-3.5-3.5"></path>
                        </svg>
                        <input type="search" id="searchInput" placeholder="မြွေအမည်ဖြင့် ရှာပါ (ဥပမာ - ငန်းမြွေ)" autocomplete="off" aria-label="မြွေအမည်ဖြင့် ရှာရန်">
                        <button type="button" class="clear-search" id="clearSearch" aria-label="ရှာဖွေမှု ရှင်းရန်">&#10005;</button>
                    </div>

                    <div class="chips" role="group" aria-label="စစ်ထုတ်ရန်">
                        <button type="button" class="chip active" data-filter="all">အားလုံး <span class="count"><?= $total ?></span></button>
                        <button type="button" class="chip" data-filter="poison">အဆိပ်ပါ <span class="count"><?= $poisonCount ?></span></button>
                        <button type="button" class="chip" data-filter="danger">အန္တရာယ်ရှိ <span class="count"><?= $dangerCount ?></span></button>
                        <button type="button" class="chip" data-filter="safe">အန္တရာယ်မရှိ <span class="count"><?= $safeCount ?></span></button>
                    </div>
                </div>
            </section>

            <section class="container" id="collection">
                <div class="section-head">
                    <h2>မြွေများ စာရင်း</h2>
                    <span class="meta"><span id="visibleCount"><?= $total ?></span> / <?= $total ?> ခု ပြသနေသည်</span>
                </div>

                <div class="grid" id="snakeGrid">
                    <?php foreach ($users as $index => $user): ?>
                        <?php
                        $isPoison = isYes($user['IsPoison'] ?? '');
                        $isDanger = isYes($user['IsDanger'] ?? '');
                        $mmName = trim($user['MMName'] ?? '');
                        $engName = trim($user['EngName'] ?? '');
                        $keyword = trim($mmName . ' ' . $engName);
                        ?>
                        <article class="card"
                            data-name="<?= e($keyword) ?>"
                            data-poison="<?= $isPoison ? '1' : '0' ?>"
                            data-danger="<?= $isDanger ? '1' : '0' ?>">
                            <a class="card-media" href="detail.php?id=<?= (int) $user['Id'] ?>" tabindex="-1" aria-hidden="true">
                                <span class="idx">#<?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                <img src="<?= e(imageUrl($user['image'] ?? '')) ?>" alt="<?= e($mmName) ?>" loading="lazy" decoding="async">
                            </a>
                            <div class="card-body">
                                <h2 class="card-title"><?= e($mmName) ?></h2>
                                <?php if ($engName !== ''): ?>
                                    <p class="card-en"><?= e($engName) ?></p>
                                <?php endif; ?>
                                <div class="tags">
                                    <span class="tag <?= $isDanger ? 'tag-danger' : 'tag-safe' ?>">
                                        <?= $isDanger ? 'အန္တရာယ်ရှိ' : 'အန္တရာယ်မရှိ' ?>
                                    </span>
                                    <span class="tag <?= $isPoison ? 'tag-poison' : 'tag-none' ?>">
                                        <?= $isPoison ? 'အဆိပ်ပါ' : 'အဆိပ်မပါ' ?>
                                    </span>
                                </div>
                                <p class="card-excerpt"><?= e(excerpt($user['Detail'] ?? '')) ?></p>
                                <a class="btn" href="detail.php?id=<?= (int) $user['Id'] ?>">
                                    အသေးစိတ် ကြည့်ရန်
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 12h13"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <p class="empty" id="emptyState" hidden>
                    <strong>ရှာဖွေမှု မတွေ့ပါ</strong>
                    အခြားအမည်တစ်ခုဖြင့် ထပ်မံ ရှာဖွေကြည့်ပါ။
                </p>
            </section>

            <footer class="container footer">
                <span>&copy; <?= date('Y') ?> မြွေအဘိဓာန် · Snake Encyclopedia</span>
                <span>သတိပေးချက် — မြွေများကို ကိုယ်တိုင် မကိုင်တွယ်ပါနှင့်။</span>
            </footer>
        </main>
    </div>

    <script>
        (function () {
            var cards = Array.prototype.slice.call(document.querySelectorAll('#snakeGrid .card'));
            var input = document.getElementById('searchInput');
            var clearBtn = document.getElementById('clearSearch');
            var emptyState = document.getElementById('emptyState');
            var visibleCount = document.getElementById('visibleCount');
            var chips = Array.prototype.slice.call(document.querySelectorAll('.chip'));
            var activeFilter = 'all';

            function matchesFilter(card) {
                if (activeFilter === 'poison') return card.dataset.poison === '1';
                if (activeFilter === 'danger') return card.dataset.danger === '1';
                if (activeFilter === 'safe') return card.dataset.danger === '0';
                return true;
            }

            function apply() {
                var query = input.value.trim().toLowerCase();
                var shown = 0;

                cards.forEach(function (card) {
                    var hit = matchesFilter(card) && (query === '' || card.dataset.name.toLowerCase().indexOf(query) !== -1);
                    card.hidden = !hit;
                    if (hit) shown++;
                });

                visibleCount.textContent = shown;
                emptyState.hidden = shown !== 0;
                clearBtn.classList.toggle('visible', input.value !== '');
            }

            input.addEventListener('input', apply);

            clearBtn.addEventListener('click', function () {
                input.value = '';
                input.focus();
                apply();
            });

            chips.forEach(function (chip) {
                chip.addEventListener('click', function () {
                    chips.forEach(function (other) { other.classList.remove('active'); });
                    chip.classList.add('active');
                    activeFilter = chip.dataset.filter;
                    apply();
                });
            });
        })();
    </script>
</body>

</html>
