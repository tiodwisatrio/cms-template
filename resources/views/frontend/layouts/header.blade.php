<header class="bg-white shadow px-8 py-5 gap-x-4 flex items-center justify-between">
    <div class="flex items-center gap-x-2">
        <h1>CMS</h1>
        <h2>Tio</h2>

    </div>
        <ul class="flex items-center justify-center gap-x-8">
            <li>
                <a href="{{ route('frontend.home') }}" 
                   class="{{ request()->routeIs('frontend.home') ? 'text-teal-600 font-semibold' : 'text-gray-700 hover:text-teal-600' }} transition duration-200">
                   Home
                </a>
            </li>
            <li>
                <a href="{{ route('frontend.home') }}" 
                   class="{{ request()->routeIs('frontend.about') ? 'text-teal-600 font-semibold' : 'text-gray-700 hover:text-teal-600' }} transition duration-200">
                   About
                </a>
            </li>
            <li>
                <a href="{{ route('frontend.blog.index') }}" 
                   class="{{ request()->routeIs('frontend.blog.*') ? 'text-teal-600 font-semibold' : 'text-gray-700 hover:text-teal-600' }} transition duration-200">
                   Blog
                </a>
            </li>
            <li>
                <a href="{{ route('frontend.products.index') }}" 
                   class="{{ request()->routeIs('frontend.products.*') ? 'text-teal-600 font-semibold' : 'text-gray-700 hover:text-teal-600' }} transition duration-200">
                   Products
                </a>
            </li>
            <li>
                <a href="{{ route('frontend.home') }}" 
                   class="{{ request()->routeIs('frontend.contact') ? 'text-teal-600 font-semibold' : 'text-gray-700 hover:text-teal-600' }} transition duration-200">
                   Contact
                </a>
            </li>
        </ul>
        @guest
    <div>
        <!-- Jika tidak login, maka ada tombol Login, jika sudah login maka ada tombol Dashboard -->
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                <a href="{{ route('login') }}">
                    Login
                </a>
            </button>
        @else
            <button class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-green-700 transition duration-200">
                <a href="{{ route('dashboard') }}" >
                    Dashboard
                </a>
            </button>
        @endguest

    </div>
</header>