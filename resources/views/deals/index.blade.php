

<?php
// Simulated user data
$user = [
    'name' => 'Christina',
    'birthday_month' => date('m'),  // Current month for testing birthday offer
    'is_logged_in' => true,
    'nic_added' => false,
    'membership' => false,
];

// Simulated user country for tourist offers
$user_country = "Germany";

// Birthday offer expiry (end of birthday month)
$birthday_offer_expiry = new DateTime(date('Y-m-t') . ' 23:59:59');
$now = new DateTime();
$interval = $now->diff($birthday_offer_expiry);
$days = $interval->format('%a');
$hours = $interval->format('%h');
$minutes = $interval->format('%i');
$seconds = $interval->format('%s');

$tourist_offers = [
    [
        'img' => 'https://i.pinimg.com/736x/87/32/67/873267e81c7c5f8a720f8db64ee5a5f3.jpg',
        'title' => 'Hotel Guest Dine-In Discount',
        'desc' => 'Enjoy 15% off your meal when you show your hotel keycard.',
        'validity' => 'Valid till 2025-06-30',
    ],
    [
        'img' => 'https://i.pinimg.com/736x/06/43/ec/0643ec2da18de339c9d001364993cec3.jpg',
        'title' => 'Airport Arrival Snack Deal',
        'desc' => 'Free drink with any snack purchase at the airport lounge.',
        'validity' => 'Valid till 2025-07-15',
    ],
    [
        'img' => 'https://i.pinimg.com/736x/6a/3e/e1/6a3ee17d3dbe31a3b666e732a1b8dffe.jpg',
        'title' => 'Tourist Welcome Dinner',
        'desc' => 'Exclusive 20% off on your first dinner at selected restaurants.',
        'validity' => 'Valid till 2025-08-01',
    ],
];

$birthday_specials = [
    [
        'img' => 'https://i.pinimg.com/736x/cf/25/d5/cf25d5eaabad7ae5a4974016cf755b08.jpg',
        'title' => 'Dine-In Birthday Special',
    ],
    [
        'img' => 'https://i.pinimg.com/736x/d5/39/57/d5395719c151610ef8f44876026a5fd3.jpg',
        'title' => 'Delivery Birthday Special',
    ],
    [
        'img' => 'https://i.pinimg.com/736x/10/3b/06/103b06e2d259805e7e3f08a037337b89.jpg',
        'title' => 'Takeaway Birthday Special',
    ],
];

$seasonal_offers = [
    [
        'img' => 'https://i.pinimg.com/736x/96/4e/a2/964ea261d43e08d2069a38f5b14a0165.jpg',
        'name' => 'Awurudu Food Combos – Up to 25% Off',
        'discount' => '25% Off',
        'validity' => '2025-04-10 to 2025-04-25',
        'outlets' => 12,
        'tag' => 'Awurudu',
    ],
    [
        'img' => 'https://i.pinimg.com/736x/cb/53/fe/cb53fefc0c0a183b3e6eb55c13585265.jpg',
        'name' => 'Christmas Roast Platter – 20% Off',
        'discount' => '20% Off',
        'validity' => '2025-12-01 to 2025-12-31',
        'outlets' => 18,
        'tag' => 'Christmas',
    ],
    [
        'img' => 'https://i.pinimg.com/736x/d9/d1/20/d9d12001278830b3938c4186d5894548.jpg',
        'name' => 'Ramadan Iftar Packages',
        'discount' => 'Special Packages',
        'validity' => '2025-04-01 to 2025-04-30',
        'outlets' => 10,
        'tag' => 'Ramadan',
    ],
    [
        'img' => 'https://i.pinimg.com/736x/a9/43/1a/a9431a6826bc838119d528862201014f.jpg',
        'name' => 'Independence Day Local Buffet Specials',
        'discount' => '15% Off',
        'validity' => '2025-02-01 to 2025-02-10',
        'outlets' => 14,
        'tag' => 'Independence',
    ],
];

$group_offers = [
    [
        'title' => 'Bring Friends, Save More',
        'desc' => 'Enjoy bigger savings when you bring your friends.',
        'offer_price' => 'Rs1,200',
        'old_price' => 'Rs1,500',
        'save' => '20%',
        'img' => 'https://i.pinimg.com/736x/8c/91/90/8c91906622cb33054d3206d3b089e906.jpg',
    ],
    [
        'title' => 'Family Bundle – Meal for 4',
        'desc' => 'Perfect combo for a family of four.',
        'offer_price' => 'Rs2,500',
        'old_price' => 'Rs3,000',
        'save' => '20%',
        'img' => 'https://i.pinimg.com/736x/f2/47/d1/f247d1aaf2c22821235d2e308482008e.jpg',
    ],
    [
        'title' => 'Couples’ Combo – Romantic Platter Deals',
        'desc' => 'Special deals for couples dining together.',
        'offer_price' => 'Rs1,800',
        'old_price' => 'Rs2,250',
        'save' => '20%',
        'img' => 'https://i.pinimg.com/736x/0e/cf/6a/0ecf6a5384f5d480c144d8498f41f879.jpg',
    ]
];


$locked_offers = [
    [
        'title' => 'VIP Member Exclusive',
        'button_text' => 'Complete Profile',
        'requirement' => 'membership',
    ],
    [
        'title' => 'Birthday Gift Package',
        'button_text' => 'Add NIC Details',
        'requirement' => 'nic_added',
    ],
    [
        'title' => 'Member Combo Special',
        'button_text' => 'Join Membership',
        'requirement' => 'membership',
    ],
];
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Special Offers - Your Next Meal Might Just Be on Us!</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .countdown-box {
      min-width: 3rem;
      min-height: 3rem;
      background: #FF6600;
      color: white;
      font-weight: 700;
      font-size: 1.25rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      border-radius: 0.5rem;
      margin-right: 0.5rem;
    }
    .countdown-label {
      font-size: 0.75rem;
      font-weight: 400;
      margin-top: 0.15rem;
    }
    /* Modal styles */
    .modal {
      transition: opacity 0.25s ease;
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-900 font-sans">
<?php include '../components/header.php'; ?>


<!-- Hero Banner -->
<section class="relative bg-black text-white">
    <img src="https://i.pinimg.com/736x/c5/86/64/c58664ccf12002f2680a230753038784.jpg" alt="Cake Background" class="absolute inset-0 w-full h-full object-cover opacity-30" />
    <div class="relative container mx-auto py-16 px-6 flex flex-col md:flex-row items-center justify-between">
        <div class="max-w-xl">
            <?php if($user['is_logged_in'] && date('m') === $user['birthday_month']): ?>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4">🎂 Happy Birthday, <?=htmlspecialchars($user['name'])?>!</h1>
                <p class="mb-8 text-lg">Here’s a Treat Just for You!</p>
                <div class="flex mb-6">
                    <div class="countdown-box">
                        <span id="days"><?=$days?></span>
                        <span class="countdown-label">Days</span>
                    </div>
                    <div class="countdown-box">
                        <span id="hours"><?=$hours?></span>
                        <span class="countdown-label">Hours</span>
                    </div>
                    <div class="countdown-box">
                        <span id="minutes"><?=$minutes?></span>
                        <span class="countdown-label">Minutes</span>
                    </div>
                    <div class="countdown-box">
                        <span id="seconds"><?=$seconds?></span>
                        <span class="countdown-label">Seconds</span>
                    </div>
                </div>
                <button onclick="openModal('birthdayModal')" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded shadow">
                    Claim Birthday Offer 🎉
                </button>
            <?php else: ?>
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Special Offers Await You!</h1>
                <p class="mb-8 text-lg">Sign up and complete your profile to unlock exclusive discounts.</p>
            <?php endif; ?>
        </div>
        <div class="w-full md:w-1/2">
            <img src="https://as1.ftcdn.net/jpg/04/52/80/04/1000_F_452800490_YoymrUVa7MYu5dBYKmWQSeK3ym2qiFHx.jpg" alt="Birthday Cake" class="rounded-lg shadow-lg" />
        </div>
    </div>
</section>

<!-- Tourist Offers -->
<section class="container mx-auto px-6 py-12">
    <h2 class="text-3xl font-bold mb-6">Tourist Offers</h2>
    <div class="flex flex-wrap justify-start gap-6">
        <?php foreach ($tourist_offers as $offer): ?>
        <div class="max-w-sm bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
            <img src="<?=htmlspecialchars($offer['img'])?>" alt="<?=htmlspecialchars($offer['title'])?>" class="h-48 w-full object-cover" />
            <div class="p-4 flex-grow flex flex-col">
                <h3 class="text-xl font-semibold mb-2"><?=htmlspecialchars($offer['title'])?></h3>
                <p class="text-gray-700 mb-4 flex-grow"><?=htmlspecialchars($offer['desc'])?></p>
                <p class="text-sm text-gray-500 mb-4"><?=htmlspecialchars($offer['validity'])?></p>
                <button onclick="openModal('touristOfferModal')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded self-start">Claim Now</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Birthday Specials Cards -->
<section class="bg-gray-100 py-12">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold mb-6">Birthday Specials – Order Your Cake 🎂</h2>
        <div class="flex flex-wrap gap-6 justify-center">
            <?php foreach ($birthday_specials as $special): ?>
            <div class="w-64 bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition-shadow">
                <img src="<?=htmlspecialchars($special['img'])?>" alt="<?=htmlspecialchars($special['title'])?>" class="h-40 w-full object-cover" />
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2"><?=htmlspecialchars($special['title'])?></h3>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Seasonal & Festival Deals -->
<section class="container mx-auto px-6 py-12">
    <h2 class="text-3xl font-bold mb-6">Seasonal & Festival Deals 🎉</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php foreach ($seasonal_offers as $offer): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
            <img src="<?=htmlspecialchars($offer['img'])?>" alt="<?=htmlspecialchars($offer['name'])?>" class="h-40 w-full object-cover" />
            <div class="p-4 flex-grow flex flex-col">
                <h3 class="font-semibold text-lg mb-1"><?=htmlspecialchars($offer['name'])?></h3>
                <p class="text-orange-500 font-bold mb-1"><?=htmlspecialchars($offer['discount'])?></p>
                <p class="text-sm text-gray-600 mb-2">Validity: <?=htmlspecialchars($offer['validity'])?></p>
                <p class="text-sm text-gray-600 mb-2"><?=htmlspecialchars($offer['outlets'])?> outlets participating</p>
                <span class="inline-block bg-green-200 text-green-800 text-xs font-semibold px-2 py-1 rounded-full self-start"><?=htmlspecialchars($offer['tag'])?></span>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Group Dining Offers -->
<section class="container mx-auto px-6 py-12">
  <h2 class="text-2xl font-bold mb-6">Group Dining Offers</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php foreach ($group_offers as $offer): ?>
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <img src="<?= htmlspecialchars($offer['img']) ?>" alt="<?= htmlspecialchars($offer['title']) ?>" class="w-full h-48 object-cover" />
        <div class="p-4">
          <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($offer['title']) ?></h3>
          <p class="mb-2"><?= htmlspecialchars($offer['desc']) ?></p>
          <div class="flex justify-between text-sm text-gray-700">
            <span class="font-bold text-orange-600"><?= $offer['offer_price'] ?></span>
            <span class="line-through"><?= $offer['old_price'] ?></span>
            <span class="text-green-600"><?= $offer['save'] ?> Save</span>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>


<!-- Locked Offers -->
<section class="container mx-auto px-6 py-12">
    <h2 class="text-3xl font-bold mb-6">Locked Offers - Complete Profile to Unlock 🔒</h2>
    <div class="flex flex-wrap gap-6 justify-center">
        <?php foreach ($locked_offers as $offer): 
            $locked = false;
            $button_action = "#";
            $button_label = $offer['button_text'];
            if ($offer['requirement'] === 'membership' && !$user['membership']) {
                $locked = true;
            }
            if ($offer['requirement'] === 'nic_added' && !$user['nic_added']) {
                $locked = true;
            }
        ?>
        <div class="w-80 bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center">
            <h3 class="text-xl font-semibold mb-4"><?=htmlspecialchars($offer['title'])?></h3>
            <?php if ($locked): ?>
                <button onclick="alert('Please complete your profile to unlock this offer.')" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded cursor-pointer">
                    <?=htmlspecialchars($button_label)?>
                </button>
            <?php else: ?>
                <button onclick="openModal('lockedOfferModal')" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded cursor-pointer">
                    Claim Offer
                </button>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Modal Container -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
  <div id="modalContent" class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
    <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-2xl font-bold">&times;</button>
    <div id="modalBody">
      <!-- Content inserted by JS -->
    </div>
  </div>
</div>

<script>
  function openModal(type) {
    const modalOverlay = document.getElementById('modalOverlay');
    const modalBody = document.getElementById('modalBody');
    modalOverlay.classList.remove('hidden');
    
    if(type === 'birthdayModal') {
      modalBody.innerHTML = `
        <h2 class="text-2xl font-bold mb-4">Happy Birthday Offer Claimed! 🎉</h2>
        <p>Thank you for claiming your birthday special. Enjoy your free cake with your next meal!</p>
        <button onclick="closeModal()" class="mt-6 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded">Close</button>
      `;
    } else if(type === 'touristOfferModal') {
      modalBody.innerHTML = `
        <h2 class="text-2xl font-bold mb-4">Tourist Offer Claim</h2>
        <p>Please show your valid ID and booking confirmation at the restaurant to redeem this offer.</p>
        <button onclick="closeModal()" class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">Close</button>
      `;
    } else if(type === 'groupOfferModal') {
      modalBody.innerHTML = `
        <h2 class="text-2xl font-bold mb-4">Group Dining Offer Claimed!</h2>
        <p>Your group dining offer has been successfully claimed. Enjoy your meal with your friends and family!</p>
        <button onclick="closeModal()" class="mt-6 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded">Close</button>
      `;
    } else if(type === 'lockedOfferModal') {
      modalBody.innerHTML = `
        <h2 class="text-2xl font-bold mb-4">Offer Claimed!</h2>
        <p>Thank you for being a valued member. Enjoy your exclusive offer!</p>
        <button onclick="closeModal()" class="mt-6 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">Close</button>
      `;
    }
  }
  
  function closeModal() {
    document.getElementById('modalOverlay').classList.add('hidden');
  }

  // Countdown timer update for Birthday offer
  <?php if($user['is_logged_in'] && date('m') === $user['birthday_month']): ?>
  let countdownDate = new Date("<?=$birthday_offer_expiry->format('Y-m-d H:i:s')?>").getTime();

  let countdownFunction = setInterval(function() {
    let now = new Date().getTime();
    let distance = countdownDate - now;

    if(distance < 0) {
      clearInterval(countdownFunction);
      document.getElementById("days").innerText = "0";
      document.getElementById("hours").innerText = "0";
      document.getElementById("minutes").innerText = "0";
      document.getElementById("seconds").innerText = "0";
      return;
    }

    let days = Math.floor(distance / (1000 * 60 * 60 * 24));
    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000*60*60));
    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000*60));
    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("days").innerText = days;
    document.getElementById("hours").innerText = hours;
    document.getElementById("minutes").innerText = minutes;
    document.getElementById("seconds").innerText = seconds;
  }, 1000);
  <?php endif; ?>
</script>

</body>
</html>
