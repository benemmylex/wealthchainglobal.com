<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mastercard Credit Card</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#EB001B',
                    secondary: '#FF5F00'
                },
                borderRadius: {
                    'none': '0px',
                    'sm': '4px',
                    DEFAULT: '8px',
                    'md': '12px',
                    'lg': '16px',
                    'xl': '20px',
                    '2xl': '24px',
                    '3xl': '32px',
                    'full': '9999px',
                    'button': '8px'
                }
            }
        }
    }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <style>
    :where([class^="ri-"])::before {
        content: "\f3c2";
    }

    @import url('https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@400;500;600&display=swap');

    .credit-card {
        aspect-ratio: 1.586 / 1;
        width: 100%;
        max-width: 420px;
        position: relative;
        /* overflow: hidden; */
        font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
        transition: transform 0.5s ease;
    }

    .gold-card {
        background: linear-gradient(135deg, #ffd700 0%, #b8860b 50%, #daa520 100%);
    }

/*     .gold-card::before {
        content: "";
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 200%;
        height: 200%;
        background: linear-gradient(135deg, rgba(255, 223, 0, 0.4) 0%, rgba(218, 165, 32, 0.2) 100%);
        transform: rotate(45deg);
        z-index: 1;
    } */

    .platinum-card {
        background: linear-gradient(135deg, #C0C0C0 0%, #E8E8E8 50%, #C0C0C0 100%);
    }

    .silver-card {
        background: linear-gradient(135deg, #d3d3d3 0%, #b0b0b0 50%, #e0e0e0 100%);
    }

/*     .platinum-card::before {
        content: "";
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 200%;
        height: 200%;
        background: linear-gradient(135deg, rgba(232, 232, 232, 0.4) 0%, rgba(192, 192, 192, 0.2) 100%);
        transform: rotate(45deg);
        z-index: 1;
    } */

    .mastercard-circles {
        position: relative;
        width: 50px;
        height: 30px;
    }

    .mastercard-circle-red {
        position: absolute;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #EB001B;
        left: 0;
        opacity: 0.9;
    }

    .mastercard-circle-yellow {
        position: absolute;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #FF5F00;
        left: 20px;
        opacity: 0.9;
    }

    .mastercard-overlap {
        position: absolute;
        width: 10px;
        height: 30px;
        background-color: #FF9900;
        opacity: 0.8;
        left: 20px;
    }
    </style>
</head>

<body class="flex items-center justify-center p-6">
    <div class="w-full max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-center gap-12">
            <div class="w-full md:w-1/3">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Gold Virtual Card</h2>
                <div class="credit-card gold-card rounded-xl shadow-xl p-6 relative z-10">
                    <!-- Company Logo and Name -->
                    <div class="flex justify-end items-start mb-4">
                        <div class="text-right">
                            <div class="flex justify-end font-['Pacifico'] text-white text-2xl mb-1"><img src="<?= base_url(); ?>assets/general/images/favicon.png" style="height: 30px;" alt="Logo" /></div>
                            <div class="text-white text-sm font-black tracking-wide"><?= SITE_TITLE; ?></div>
                        </div>
                    </div>
                    <!-- Card Number -->
                    <div class="mb-4">
                        <div class="text-white text-2xl tracking-wider flex justify-center gap-4 font-black">
                            <span>****</span>
                            <span>****</span>
                            <span>****</span>
                            <span>9845</span>
                        </div>
                    </div>
                    <!-- Card Details -->
                    <div class="flex justify-between items-end">
                        <div>
                            <div class="text-white text-lg font-black tracking-wide"><?php echo $name ?></div>
                        </div>
                        <div class="flex flex-col items-end">
                            <div class="text-white text-xs mb-1">VALID THRU</div>
                            <div class="text-white text-base font-black mb-2">07/28</div>
                            <div class="mastercard-circles holographic-effect rounded-md p-1">
                                <div class="mastercard-circle-red"></div>
                                <div class="mastercard-circle-yellow"></div>
                                <div class="mastercard-overlap"></div>
                            </div>
                        </div>
                    </div>
                    <!-- Card Network -->
                    <div class="float-right py-2 text-white text-xs font-black">
                        MASTERCARD
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/3">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Silver Virtual Card</h2>
                <div class="credit-card silver-card rounded-xl shadow-xl p-6 relative z-10">
                    <div class="flex justify-end items-start mb-4">
                        <div class="text-right">
                            <div class="flex justify-end font-['Pacifico'] text-gray-700 text-2xl mb-1"><img src="<?= base_url(); ?>assets/general/images/favicon.png" style="height: 30px;" alt="Logo" /></div>
                            <div class="text-gray-700 text-sm font-medium tracking-wide"><?= SITE_TITLE; ?></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="text-gray-800 text-2xl tracking-wider flex justify-center gap-4 font-black">
                            <span>****</span>
                            <span>****</span>
                            <span>****</span>
                            <span>9845</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <div class="text-gray-800 text-lg font-black tracking-wide"><?php echo $name ?></div>
                        </div>
                        <div class="flex flex-col items-end">
                            <div class="text-gray-700 text-xs mb-1">VALID THRU</div>
                            <div class="text-gray-800 text-base font-black mb-2">07/28</div>
                            <div class="mastercard-circles holographic-effect rounded-md p-1">
                                <div class="mastercard-circle-red"></div>
                                <div class="mastercard-circle-yellow"></div>
                                <div class="mastercard-overlap"></div>
                            </div>
                        </div>
                    </div>
                    <div class="float-right py-2 text-gray-700 text-xs font-black">
                        MASTERCARD
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/3">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">Platinum Virtual Card</h2>
                <div class="credit-card platinum-card rounded-xl shadow-xl p-6 relative z-10">
                    <div class="flex justify-end items-start mb-4">
                        <div class="text-right">
                            <div class="flex justify-end font-['Pacifico'] text-gray-800 text-2xl mb-1"><img src="<?= base_url(); ?>assets/general/images/favicon.png" style="height: 30px;" alt="Logo" /></div>
                            <div class="text-black text-sm font-medium tracking-wide"><?= SITE_TITLE; ?></div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="text-black text-2xl tracking-wider flex justify-center gap-4 font-black">
                            <span>****</span>
                            <span>****</span>
                            <span>****</span>
                            <span>9845</span>
                        </div>
                    </div>
                    <div class="flex justify-between items-end">
                        <div>
                            <div class="text-black text-lg font-black tracking-wide"><?php echo $name ?></div>
                        </div>
                        <div class="flex flex-col items-end">
                            <div class="text-black text-xs mb-1">VALID THRU</div>
                            <div class="text-black text-base font-black mb-2">07/28</div>
                            <div class="mastercard-circles holographic-effect rounded-md p-1">
                                <div class="mastercard-circle-red"></div>
                                <div class="mastercard-circle-yellow"></div>
                                <div class="mastercard-overlap"></div>
                            </div>
                        </div>
                    </div>
                    <div class="float-right py-2 text-black text-xs font-black">
                        MASTERCARD
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script id="cardInteraction">
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.credit-card');
        cards.forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateY = ((x - centerX) / centerX) * 5;
                const rotateX = ((y - centerY) / centerY) * -5;
                card.style.transform =
                    `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });
            card.addEventListener('mouseleave', function() {
                card.style.transform = 'perspective(1000px) rotateX(0) rotateY(0)';
                card.style.transition = 'transform 0.5s ease';
            });
            card.addEventListener('mouseenter', function() {
                card.style.transition = 'transform 0.1s ease';
            });
        });
    });
    </script>
</body>

</html>