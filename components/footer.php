<footer class="bg-gray-900 text-gray-300 mt-0">

    <!-- Top divider -->
    <div class="border-t border-gray-700"></div>

    <!-- Main footer columns -->
    <div class="max-w-6xl mx-auto px-4 py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

        <!-- Col 1: Office address -->
        <div>
            <h4 class="text-white font-bold text-base mb-3">Registered Office</h4>
            <p class="text-sm text-gray-400 leading-relaxed">
                <a href="https://maps.google.com" target="_blank" rel="noopener" class="hover:text-white transition-colors">
                    123, Business Park, Sector 5,<br>
                    New Delhi, India 110001
                </a>
            </p>
            <h4 class="text-white font-bold text-base mt-6 mb-3">Branch Office</h4>
            <p class="text-sm text-gray-400 leading-relaxed">
                <a href="https://maps.google.com" target="_blank" rel="noopener" class="hover:text-white transition-colors">
                    7th Floor, Tower B, Cyber City,<br>
                    Gurugram, Haryana 122002
                </a>
            </p>
        </div>

        <!-- Col 2: Our Solutions -->
        <div>
            <h4 class="text-white font-bold text-base mb-3">Our Solutions</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="<?= APP_URL ?>/services/real-estate" class="hover:text-white transition-colors">Real Estate Services</a></li>
                <li><a href="<?= APP_URL ?>/services/property-management" class="hover:text-white transition-colors">Property Management</a></li>
                <li><a href="<?= APP_URL ?>/services/investment-advisory" class="hover:text-white transition-colors">Investment Advisory</a></li>
                <li><a href="<?= APP_URL ?>/services/legal-documentation" class="hover:text-white transition-colors">Legal Documentation</a></li>
            </ul>
        </div>

        <!-- Col 3: Company links -->
        <div>
            <h4 class="text-white font-bold text-base mb-3">Company</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li><a href="<?= APP_URL ?>/"        class="hover:text-white transition-colors">Home</a></li>
                <li><a href="<?= APP_URL ?>/about"   class="hover:text-white transition-colors">About</a></li>
                <li><a href="<?= APP_URL ?>/services" class="hover:text-white transition-colors">Services</a></li>
                <li><a href="<?= APP_URL ?>/blog"    class="hover:text-white transition-colors">Blog</a></li>
                <li><a href="<?= APP_URL ?>/contact" class="hover:text-white transition-colors">Contact Us</a></li>
            </ul>
        </div>

        <!-- Col 4: Contact + Social -->
        <div>
            <h4 class="text-white font-bold text-base mb-3">Email Support</h4>
            <p class="text-sm text-gray-400 mb-4">
                <a href="mailto:info@yoursite.com" class="hover:text-white transition-colors">info@yoursite.com</a>
            </p>

            <h4 class="text-white font-bold text-base mb-3">Let's Talk</h4>
            <p class="text-sm text-gray-400 mb-6">
                <a href="tel:+911234567890" class="hover:text-white transition-colors">+91 12345 67890</a>
            </p>

            <!-- Social icons -->
            <div class="flex gap-3">
                <!-- Facebook -->
                <a href="#" target="_blank" rel="noopener"
                   class="w-9 h-9 rounded-full bg-gray-700 hover:bg-blue-600 flex items-center justify-center transition-colors"
                   aria-label="Facebook">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 320 512">
                        <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/>
                    </svg>
                </a>
                <!-- Instagram -->
                <a href="#" target="_blank" rel="noopener"
                   class="w-9 h-9 rounded-full bg-gray-700 hover:bg-pink-600 flex items-center justify-center transition-colors"
                   aria-label="Instagram">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 448 512">
                        <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                    </svg>
                </a>
                <!-- LinkedIn -->
                <a href="#" target="_blank" rel="noopener"
                   class="w-9 h-9 rounded-full bg-gray-700 hover:bg-blue-700 flex items-center justify-center transition-colors"
                   aria-label="LinkedIn">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 448 512">
                        <path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom divider + copyright -->
    <div class="border-t border-gray-700">
        <div class="max-w-6xl mx-auto px-4 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <span>Copyright &copy; <?= date('Y') ?> MySite. All rights reserved.</span>
            <ul class="flex gap-4">
                <li><a href="<?= APP_URL ?>/terms"          class="hover:text-white transition-colors">Terms of Use</a></li>
                <li><a href="<?= APP_URL ?>/privacy-policy" class="hover:text-white transition-colors">Privacy Policy</a></li>
                <li><a href="<?= APP_URL ?>/cookie-policy"  class="hover:text-white transition-colors">Cookie Policy</a></li>
            </ul>
        </div>
    </div>

</footer>
