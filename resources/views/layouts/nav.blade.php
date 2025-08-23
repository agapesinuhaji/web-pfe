<header class="absolute inset-x-0 top-0 z-50 ">
    <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8 ">
      <div class="flex lg:flex-1 ">
        <a href="{{ url('/') }}" class="-m-1.5 p-1.5 ">
          <span class="sr-only text-white">Your Company</span>
          <img src="{{ asset('favicon.svg') }}" alt="" class="h-8 w-auto" />
        </a>
      </div>
      <div class="flex lg:hidden">
        <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
          <span class="sr-only">Open main menu</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <div class="hidden lg:flex lg:gap-x-12">
        <a href="{{ url('/') }}" class="text-sm/6 font-semibold text-gray-700">Home</a>
        <a href="{{ url('/#our-team') }}" class="text-sm/6 font-semibold text-gray-700">Our Team</a>
        <a href="{{ url('/#services') }}" class="text-sm/6 font-semibold text-gray-700">Services</a>
        <a href="{{ url('/#contact') }}" class="text-sm/6 font-semibold text-gray-700">Contact</a>
        @auth
          @if (auth()->user()->role == 'user')
            <a href="{{url('my-order') }}" class="text-sm/6 font-semibold text-gray-700">My Orders</a>
          @elseif (auth()->user()->role == 'administrator')
            <a href="{{ url('/dashboard') }}" class="text-sm/6 font-semibold text-gray-700">Dashboard</a>
          @elseif (auth()->user()->role == 'psikolog')
            <a href="{{ url('/my-task') }}" class="text-sm/6 font-semibold text-gray-700">My Tasks</a>
          @endif

        @endauth
      </div>
      <div class="hidden lg:flex lg:flex-1 lg:justify-end">
        @guest
        <a href="/login" class="text-sm/6 font-semibold text-gray-700">Log in <span aria-hidden="true">&rarr;</span></a>
        @endguest

        @auth
        <!-- Kalau user sudah login -->
        <div x-data="{ open: false }" class="relative">
            <!-- Tombol dropdown -->
            <button @click="open = !open" class="flex items-center gap-2 rounded-full border border-gray-200 bg-white px-3 py-1 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <img src="{{ asset(Auth::user()->profile->image) ?? asset('default-avatar.png') }}" alt="Profile Picture" class="h-8 w-8 rounded-full object-cover">
                <span>{{ Auth::user()->profile->name }}</span>
                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div x-show="open" 
                 @click.away="open = false" 
                 x-transition 
                 class="absolute right-0 mt-2 w-48 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                <div class="py-1">
                    <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>



        @endauth
      </div>
    </nav>
    <el-dialog>
      <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
        <div tabindex="0" class="fixed inset-0 focus:outline-none">
          <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-between">
              <a href="{{ url('/') }}" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img src="{{ asset('favicon.svg') }}" alt="" class="h-8 w-auto" />
              </a>
              <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                <span class="sr-only">Close menu</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                  <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
            <div class="mt-6 flow-root">
              <div class="-my-6 divide-y divide-gray-500/10">
                <div class="space-y-2 py-6">
                  <a href="{{ url('/') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Home</a>
                  <a href="{{ url('/#our-team') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Our Team</a>
                  <a href="{{ url('/#services') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Services</a>
                  <a href="{{ url('/#contact') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Contact</a>
                  @auth
                    @if (auth()->user()->role == 'user')
                      <a href="{{ url('/my-order') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">My Orders</a>
                    @elseif (auth()->user()->role == 'administrator')
                      <a href="{{ url('/dashboard') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Dashboard</a>
                    @elseif (auth()->user()->role == 'psikolog')
                    <a href="{{ url('/my-task') }}" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">My Tasks</a>
                     @endif
                  @endauth
                </div>
                <div class="py-6">  
                  @guest
                  <a href="/login" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Log in</a>
                  @endguest

                  @auth
                    <!-- Jika user sudah login -->
                    <div class="flex items-center gap-3 px-3 py-2">
                      <img src="{{ asset(Auth::user()->profile->image) ?? asset('default-avatar.png') }}" 
                          alt="User Avatar" 
                          class="h-10 w-10 rounded-full object-cover">
                      <div>
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->profile->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                      </div>
                    </div>
                    <div class="mt-4 space-y-1">
                      <a href="/profile" class="-mx-3 block rounded-lg px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50">
                        Profile
                      </a>
                      <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="w-full text-left -mx-3 block rounded-lg px-3 py-2 text-base font-medium text-gray-900 hover:bg-gray-50">
                          Logout
                        </button>
                      </form>
                    </div>  

                  @endauth
                </div>
              </div>
            </div>
          </el-dialog-panel>
        </div>
      </dialog>
    </el-dialog>
  </header>