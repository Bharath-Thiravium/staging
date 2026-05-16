<nav>
    <ul class="flex gap-6 text-sm font-medium text-gray-600">
        <li><a href="<?= APP_URL ?>/"      class="hover:text-black">Home</a></li>
        <li><a href="<?= APP_URL ?>/blog"  class="hover:text-black">Blog</a></li>
        <li class="relative group">
            <a href="<?= APP_URL ?>/services" class="hover:text-black flex items-center gap-1">
                Services
                <svg class="w-3 h-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </a>
            <!-- Dropdown -->
            <ul class="absolute left-0 top-full mt-1 w-52 bg-white border border-gray-100 rounded-lg shadow-lg
                        opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                <li>
                    <a href="<?= APP_URL ?>/services/real-estate"
                       class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 rounded-t-lg">
                        Real Estate Services
                    </a>
                </li>
            </ul>
        </li>
        <li><a href="<?= APP_URL ?>/about"   class="hover:text-black">About</a></li>
        <li><a href="<?= APP_URL ?>/contact" class="hover:text-black">Contact</a></li>
    </ul>
</nav>
