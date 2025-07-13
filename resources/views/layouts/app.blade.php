<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gerenciador de Contatos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --sidebar-bg: #1e3a8a;
            --sidebar-hover: #1e40af;
        }

        .sidebar-collapsed {
            width: 5rem;
            min-width: 5rem;
        }

        .sidebar-expanded {
            width: 16rem;
            min-width: 16rem;
        }

        .transition-width {
            transition: width 0.3s ease;
        }

        /* Previne layout shift - define estado inicial */
        .sidebar-initial {
            width: 16rem;
            min-width: 16rem;
        }

        /* Esconde elementos até Alpine.js estar pronto */
        [x-cloak] {
            display: none !important;
        }

        /* Transições suaves para elementos x-show */
        .alpine-enter {
            opacity: 0;
            transform: scale(0.95);
        }

        .alpine-enter-active {
            opacity: 1;
            transform: scale(1);
            transition: opacity 0.2s, transform 0.2s;
        }

        .alpine-leave {
            opacity: 1;
            transform: scale(1);
        }

        .alpine-leave-active {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.2s, transform 0.2s;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex min-h-screen w-full" x-data="{
        sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen')) ?? true,
        init() {
            this.$watch('sidebarOpen', value => {
                localStorage.setItem('sidebarOpen', JSON.stringify(value))
            })
        }
    }" x-cloak>
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'sidebar-expanded' : 'sidebar-collapsed'"
            class="transition-width flex flex-col bg-blue-900 text-white sidebar-initial">
            <div class="p-4">
                <div class="flex items-center" x-show="sidebarOpen" x-transition.opacity.duration.200ms>
                    <i class="fas fa-address-book mr-3 text-2xl text-blue-200"></i>
                    <h2 class="text-xl font-bold text-white">Contatos</h2>
                </div>
                <div class="flex justify-center" x-show="!sidebarOpen" x-transition.opacity.duration.200ms>
                    <i class="fas fa-address-book text-2xl text-blue-200"></i>
                </div>
            </div>

            <nav class="flex-1 px-4 pb-4">
                <div class="space-y-2">
                    <a href="{{ route('contacts.index') }}"
                        class="{{ request()->routeIs('contacts.index') ? 'bg-blue-800 text-white font-medium' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
                        <i class="fas fa-users h-5 w-5"></i>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Lista de Contatos</span>
                    </a>
                    <a href="{{ route('contacts.create') }}"
                        class="{{ request()->routeIs('contacts.create') ? 'bg-blue-800 text-white font-medium' : 'text-blue-100 hover:bg-blue-800 hover:text-white' }} flex items-center gap-3 rounded-lg px-3 py-2 transition-colors">
                        <i class="fas fa-user-plus h-5 w-5"></i>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Novo Contato</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex flex-1 flex-col">
            <!-- Header -->
            <header class="flex h-16 items-center border-b border-gray-200 bg-white px-6 shadow-sm">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="mr-4 rounded-lg p-2 transition-colors hover:bg-gray-100">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
                <h1 class="text-2xl font-bold text-gray-900">Gerenciador de Contatos</h1>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 left-1/2 z-50 hidden -translate-x-1/2">
        <div class="rounded-lg bg-green-500 px-6 py-3 text-white shadow-lg">
            <span id="toast-message"></span>
        </div>
    </div>

    <script>
        function showToast(message) {
            const toast = document.getElementById('toast');
            const messageEl = document.getElementById('toast-message');
            messageEl.textContent = message;
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        // Show success message if it exists
        @if (session('success'))
            showToast('{{ session('success') }}');
        @endif
    </script>
</body>

</html>
