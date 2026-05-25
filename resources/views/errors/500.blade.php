<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>500 - Kesalahan Internal Server | Posyandu Kenanga</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Public+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased overflow-x-hidden bg-white dark:bg-gray-900 text-gray-800 dark:text-white/90">
    <div class="relative flex flex-col justify-between min-h-screen p-6 overflow-hidden z-10">
        
        <!-- Top Spacer -->
        <div class="hidden sm:block h-10"></div>

        <!-- GridBackground (GridShape.tsx equivalent) -->
        <!-- Top Right Grid -->
        <div class="absolute right-0 top-0 -z-10 w-full max-w-[250px] xl:max-w-[450px]">
            <svg width="450" height="254" viewBox="0 0 450 254" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.50555 45.1131L450 45.1132L450 44.6073L0.50555 44.6072L0.50555 45.1131Z" fill="url(#paint0_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M205.546 253.529L205.546 -2.13709e-05L205.04 -2.1392e-05L205.04 253.529L205.546 253.529Z" fill="url(#paint1_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.505546 97.2164L450 97.2165L450 96.7106L0.505546 96.7106L0.505546 97.2164Z" fill="url(#paint2_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M256.806 253.529L256.806 -1.68895e-05L256.3 -1.69106e-05L256.3 253.529L256.806 253.529Z" fill="url(#paint3_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.505837 253.529L0.505859 -3.9296e-05L0 -3.93171e-05L-2.21642e-05 253.529L0.505837 253.529Z" fill="url(#paint4_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.505541 149.321L450 149.321L450 148.815L0.505541 148.815L0.505541 149.321Z" fill="url(#paint5_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M308.066 253.529L308.066 -1.24083e-05L307.56 -1.24294e-05L307.56 253.529L308.066 253.529Z" fill="url(#paint6_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M51.7662 253.529L51.7662 -3.48147e-05L51.2603 -3.48358e-05L51.2603 253.529L51.7662 253.529Z" fill="url(#paint7_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.505537 201.424L450 201.424L450 200.918L0.505537 200.918L0.505537 201.424Z" fill="url(#paint8_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M359.326 253.529L359.326 -7.92695e-06L358.82 -7.94806e-06L358.82 253.529L359.326 253.529Z" fill="url(#paint9_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M103.026 253.529L103.026 -3.03334e-05L102.52 -3.03545e-05L102.52 253.529L103.026 253.529Z" fill="url(#paint10_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M410.586 253.529L410.586 -3.44569e-06L410.08 -3.4668e-06L410.08 253.529L410.586 253.529Z" fill="url(#paint11_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M154.286 253.529L154.286 -2.58521e-05L153.78 -2.58732e-05L153.78 253.529L154.286 253.529Z" fill="url(#paint12_linear_3005_4084)" fill-opacity="0.3"/>
                <rect width="50.7536" height="51.5982" transform="matrix(-1 -8.74228e-08 -8.74228e-08 1 358.821 45.1138)" fill="#B2B2B2" fill-opacity="0.08"/>
                <rect width="50.756" height="51.5985" transform="matrix(-1 -8.74228e-08 -8.74228e-08 1 307.559 97.2163)" fill="#B2B2B2" fill-opacity="0.08"/>
                <defs>
                <linearGradient id="paint0_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint1_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint2_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint3_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint4_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint5_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint6_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint7_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint8_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint9_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint10_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint11_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint12_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                </defs>
            </svg>
        </div>
        
        <!-- Bottom Left Grid (rotated 180 deg) -->
        <div class="absolute bottom-0 left-0 -z-10 w-full max-w-[250px] rotate-180 xl:max-w-[450px]">
            <svg width="450" height="254" viewBox="0 0 450 254" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.50555 45.1131L450 45.1132L450 44.6073L0.50555 44.6072L0.50555 45.1131Z" fill="url(#paint0_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M205.546 253.529L205.546 -2.13709e-05L205.04 -2.1392e-05L205.04 253.529L205.546 253.529Z" fill="url(#paint1_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.505546 97.2164L450 97.2165L450 96.7106L0.505546 96.7106L0.505546 97.2164Z" fill="url(#paint2_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M256.806 253.529L256.806 -1.68895e-05L256.3 -1.69106e-05L256.3 253.529L256.806 253.529Z" fill="url(#paint3_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.505837 253.529L0.505859 -3.9296e-05L0 -3.93171e-05L-2.21642e-05 253.529L0.505837 253.529Z" fill="url(#paint4_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.505541 149.321L450 149.321L450 148.815L0.505541 148.815L0.505541 149.321Z" fill="url(#paint5_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M308.066 253.529L308.066 -1.24083e-05L307.56 -1.24294e-05L307.56 253.529L308.066 253.529Z" fill="url(#paint6_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M51.7662 253.529L51.7662 -3.48147e-05L51.2603 -3.48358e-05L51.2603 253.529L51.7662 253.529Z" fill="url(#paint7_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.505537 201.424L450 201.424L450 200.918L0.505537 200.918L0.505537 201.424Z" fill="url(#paint8_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M359.326 253.529L359.326 -7.92695e-06L358.82 -7.94806e-06L358.82 253.529L359.326 253.529Z" fill="url(#paint9_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M103.026 253.529L103.026 -3.03334e-05L102.52 -3.03545e-05L102.52 253.529L103.026 253.529Z" fill="url(#paint10_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M410.586 253.529L410.586 -3.44569e-06L410.08 -3.4668e-06L410.08 253.529L410.586 253.529Z" fill="url(#paint11_linear_3005_4084)" fill-opacity="0.3"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M154.286 253.529L154.286 -2.58521e-05L153.78 -2.58732e-05L153.78 253.529L154.286 253.529Z" fill="url(#paint12_linear_3005_4084)" fill-opacity="0.3"/>
                <rect width="50.7536" height="51.5982" transform="matrix(-1 -8.74228e-08 -8.74228e-08 1 358.821 45.1138)" fill="#B2B2B2" fill-opacity="0.08"/>
                <rect width="50.756" height="51.5985" transform="matrix(-1 -8.74228e-08 -8.74228e-08 1 307.559 97.2163)" fill="#B2B2B2" fill-opacity="0.08"/>
                <defs>
                <linearGradient id="paint0_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint1_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint2_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint3_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint4_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint5_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint6_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint7_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint8_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint9_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint10_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint11_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                <linearGradient id="paint12_linear_3005_4084" x1="277.872" y1="-9.94587e-06" x2="194.87" y2="235.867" gradientUnits="userSpaceOnUse">
                <stop stop-color="#B2B2B2"/>
                <stop offset="1" stop-color="#B2B2B2" stop-opacity="0"/>
                </linearGradient>
                </defs>
            </svg>
        </div>
        
        <div class="mx-auto w-full max-w-[242px] text-center sm:max-w-[472px] my-auto py-12">
            <h1 class="mb-8 font-black tracking-tight text-gray-800 dark:text-white/90 text-3xl sm:text-4xl font-jakarta">
                ERROR 500
            </h1>

            <!-- Light Mode SVG -->
            <div class="block dark:hidden mx-auto text-white dark:text-gray-900">
                <svg width="472" height="158" viewBox="0 0 472 158" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                    <!-- Left Gear -->
                    <g>
                        <line x1="80" y1="46" x2="80" y2="114" stroke="#465FFF" stroke-width="14" stroke-linecap="round"/>
                        <line x1="46" y1="80" x2="114" y2="80" stroke="#465FFF" stroke-width="14" stroke-linecap="round"/>
                        <line x1="56" y1="56" x2="104" y2="104" stroke="#465FFF" stroke-width="14" stroke-linecap="round"/>
                        <line x1="56" y1="104" x2="104" y2="56" stroke="#465FFF" stroke-width="14" stroke-linecap="round"/>
                        <circle cx="80" cy="80" r="26" fill="#465FFF"/>
                        <circle cx="80" cy="80" r="16" fill="currentColor"/>
                        <circle cx="80" cy="80" r="6" fill="#465FFF"/>
                    </g>
                    <!-- Center Server -->
                    <rect x="162" y="15" width="148" height="128" rx="20" stroke="#465FFF" stroke-width="16"/>
                    <rect x="186" y="38" width="100" height="18" rx="4" fill="#465FFF"/>
                    <rect x="186" y="70" width="100" height="18" rx="4" fill="#465FFF"/>
                    <rect x="186" y="102" width="100" height="18" rx="4" fill="#465FFF"/>
                    <circle cx="198" cy="47" r="4" fill="white" class="fill-white"/>
                    <circle cx="198" cy="79" r="4" fill="white" class="fill-white"/>
                    <circle cx="198" cy="111" r="4" fill="white" class="fill-white"/>
                    <line x1="214" y1="47" x2="274" y2="47" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <line x1="214" y1="79" x2="274" y2="79" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <line x1="214" y1="111" x2="274" y2="111" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <!-- Right Gear -->
                    <g>
                        <line x1="392" y1="56" x2="392" y2="104" stroke="#465FFF" stroke-width="10" stroke-linecap="round"/>
                        <line x1="368" y1="80" x2="416" y2="80" stroke="#465FFF" stroke-width="10" stroke-linecap="round"/>
                        <line x1="376" y1="64" x2="408" y2="96" stroke="#465FFF" stroke-width="10" stroke-linecap="round"/>
                        <line x1="376" y1="96" x2="408" y2="64" stroke="#465FFF" stroke-width="10" stroke-linecap="round"/>
                        <circle cx="392" cy="80" r="18" fill="#465FFF"/>
                        <circle cx="392" cy="80" r="11" fill="currentColor"/>
                        <circle cx="392" cy="80" r="4" fill="#465FFF"/>
                    </g>
                </svg>
            </div>

            <!-- Dark Mode SVG -->
            <div class="hidden dark:block mx-auto text-white dark:text-gray-900">
                <svg width="472" height="158" viewBox="0 0 472 158" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                    <!-- Left Gear -->
                    <g>
                        <line x1="80" y1="46" x2="80" y2="114" stroke="#7592FF" stroke-width="14" stroke-linecap="round"/>
                        <line x1="46" y1="80" x2="114" y2="80" stroke="#7592FF" stroke-width="14" stroke-linecap="round"/>
                        <line x1="56" y1="56" x2="104" y2="104" stroke="#7592FF" stroke-width="14" stroke-linecap="round"/>
                        <line x1="56" y1="104" x2="104" y2="56" stroke="#7592FF" stroke-width="14" stroke-linecap="round"/>
                        <circle cx="80" cy="80" r="26" fill="#7592FF"/>
                        <circle cx="80" cy="80" r="16" fill="currentColor"/>
                        <circle cx="80" cy="80" r="6" fill="#7592FF"/>
                    </g>
                    <!-- Center Server -->
                    <rect x="162" y="15" width="148" height="128" rx="20" stroke="#7592FF" stroke-width="16"/>
                    <rect x="186" y="38" width="100" height="18" rx="4" fill="#7592FF"/>
                    <rect x="186" y="70" width="100" height="18" rx="4" fill="#7592FF"/>
                    <rect x="186" y="102" width="100" height="18" rx="4" fill="#7592FF"/>
                    <circle cx="198" cy="47" r="4" fill="white" class="fill-white"/>
                    <circle cx="198" cy="79" r="4" fill="white" class="fill-white"/>
                    <circle cx="198" cy="111" r="4" fill="white" class="fill-white"/>
                    <line x1="214" y1="47" x2="274" y2="47" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <line x1="214" y1="79" x2="274" y2="79" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <line x1="214" y1="111" x2="274" y2="111" stroke="white" stroke-width="4" stroke-linecap="round"/>
                    <!-- Right Gear -->
                    <g>
                        <line x1="392" y1="56" x2="392" y2="104" stroke="#7592FF" stroke-width="10" stroke-linecap="round"/>
                        <line x1="368" y1="80" x2="416" y2="80" stroke="#7592FF" stroke-width="10" stroke-linecap="round"/>
                        <line x1="376" y1="64" x2="408" y2="96" stroke="#7592FF" stroke-width="10" stroke-linecap="round"/>
                        <line x1="376" y1="96" x2="408" y2="64" stroke="#7592FF" stroke-width="10" stroke-linecap="round"/>
                        <circle cx="392" cy="80" r="18" fill="#7592FF"/>
                        <circle cx="392" cy="80" r="11" fill="currentColor"/>
                        <circle cx="392" cy="80" r="4" fill="#7592FF"/>
                    </g>
                </svg>
            </div>

            <p class="mt-10 mb-6 text-base text-gray-600 dark:text-gray-400 sm:text-lg font-jakarta">
                Terjadi kesalahan internal pada server kami. Silakan hubungi admin atau coba beberapa saat lagi.
            </p>

            <a href="{{ url('/') }}" class="inline-flex items-center justify-center rounded-xl bg-primary px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-primary/20 hover:bg-primary-dark transition-all duration-300 transform hover:-translate-y-0.5">
                Kembali ke Beranda
            </a>
        </div>

        <!-- Footer -->
        <div class="w-full text-center pb-6">
            <p class="text-sm text-gray-400 dark:text-gray-500 font-jakarta">
                &copy; {{ date('Y') }} - Posyandu Kenanga. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
