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

        /* Transições de página */
        .page-transition {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .page-fade-out {
            opacity: 0;
            transform: translateY(10px);
        }

        .page-fade-in {
            opacity: 1;
            transform: translateY(0);
        }

        /* Overlay de loading durante transição */
        .transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(2px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .transition-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Spinner de loading */
        .loading-spinner {
            width: 32px;
            height: 32px;
            border: 3px solid #e5e7eb;
            border-top: 3px solid #2563eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Inicialização da página */
        .page-content {
            opacity: 0;
            transform: translateY(10px);
            animation: pageLoad 0.4s ease forwards;
        }

        @keyframes pageLoad {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Overlay de transição -->
    <div id="transitionOverlay" class="transition-overlay">
        <div class="loading-spinner"></div>
    </div>

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
                    <a href="{{ route('contacts.index') }}" data-route="contacts.index"
                        class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-2 transition-colors page-link">
                        <i class="fas fa-users h-5 w-5"></i>
                        <span x-show="sidebarOpen" x-transition.opacity.duration.200ms>Lista de Contatos</span>
                    </a>
                    <a href="{{ route('contacts.create') }}" data-route="contacts.create"
                        class="sidebar-link flex items-center gap-3 rounded-lg px-3 py-2 transition-colors page-link">
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
            <main class="flex-1 p-6 page-content" id="mainContent">
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
        // Sistema de transição de páginas
        class PageTransition {
            constructor() {
                this.overlay = document.getElementById('transitionOverlay');
                this.mainContent = document.getElementById('mainContent');
                this.isTransitioning = false;

                this.init();
                this.updateActiveRoute(); // Atualiza rota ativa na inicialização
            }

            init() {
                // Intercepta cliques em links com classe 'page-link'
                document.addEventListener('click', (e) => {
                    const link = e.target.closest('.page-link');
                    if (link && !this.isTransitioning) {
                        e.preventDefault();
                        this.navigateToPage(link.href);
                    }
                });

                // Intercepta cliques em outros links internos
                document.addEventListener('click', (e) => {
                    const link = e.target.closest('a[href]');
                    if (link &&
                        !link.classList.contains('page-link') &&
                        !link.hasAttribute('target') &&
                        !link.href.includes('#') &&
                        !link.href.includes('mailto:') &&
                        !link.href.includes('tel:') &&
                        link.href.startsWith(window.location.origin) &&
                        !this.isTransitioning) {
                        e.preventDefault();
                        this.navigateToPage(link.href);
                    }
                });

                // Intercepta navegação do browser (back/forward)
                window.addEventListener('popstate', () => {
                    if (!this.isTransitioning) {
                        this.navigateToPage(window.location.href, false);
                    }
                });
            }

            // Atualiza o estado ativo dos links do sidebar
            updateActiveRoute() {
                const currentPath = window.location.pathname;
                const sidebarLinks = document.querySelectorAll('.sidebar-link');

                sidebarLinks.forEach(link => {
                    const linkPath = new URL(link.href).pathname;
                    const isActive = linkPath === currentPath ||
                                   (currentPath.includes('/contacts/') && currentPath.includes('/edit') && link.dataset.route === 'contacts.index') ||
                                   (currentPath.includes('/contacts/') && !currentPath.includes('/create') && !currentPath.includes('/edit') && currentPath !== '/contacts' && link.dataset.route === 'contacts.index');

                    // Remove classes ativas de todos os links
                    link.classList.remove('bg-blue-800', 'text-white', 'font-medium');
                    link.classList.add('text-blue-100', 'hover:bg-blue-800', 'hover:text-white');

                    // Aplica classes ativas no link atual
                    if (isActive) {
                        link.classList.remove('text-blue-100', 'hover:bg-blue-800', 'hover:text-white');
                        link.classList.add('bg-blue-800', 'text-white', 'font-medium');
                    }
                });
            }

            // Função mais específica para detectar rota ativa
            getActiveRouteFromPath(path) {
                if (path === '/contacts' || path === '/contacts/') {
                    return 'contacts.index';
                }
                if (path.includes('/contacts/create')) {
                    return 'contacts.create';
                }
                if (path.includes('/contacts/') && (path.includes('/edit') || path.match(/\/contacts\/\d+$/))) {
                    return 'contacts.index'; // Editar e visualizar contatos fazem parte da gestão de contatos
                }
                return null;
            }

            // Versão melhorada da atualização de rota ativa
            updateActiveRouteImproved() {
                const currentPath = window.location.pathname;
                const activeRoute = this.getActiveRouteFromPath(currentPath);
                const sidebarLinks = document.querySelectorAll('.sidebar-link');

                sidebarLinks.forEach(link => {
                    const linkRoute = link.dataset.route;
                    const isActive = linkRoute === activeRoute;

                    // Remove classes ativas de todos os links
                    link.classList.remove('bg-blue-800', 'text-white', 'font-medium');
                    link.classList.add('text-blue-100', 'hover:bg-blue-800', 'hover:text-white');

                    // Aplica classes ativas no link atual
                    if (isActive) {
                        link.classList.remove('text-blue-100', 'hover:bg-blue-800', 'hover:text-white');
                        link.classList.add('bg-blue-800', 'text-white', 'font-medium');
                    }
                });
            }

            async navigateToPage(url, pushState = true) {
                if (this.isTransitioning) return;

                this.isTransitioning = true;

                try {
                    // Fade out da página atual
                    this.mainContent.classList.add('page-fade-out');
                    this.overlay.classList.add('active');

                    // Aguarda a transição de fade out
                    await new Promise(resolve => setTimeout(resolve, 150));

                    // Carrega a nova página
                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Erro ao carregar página');

                    const html = await response.text();
                    const parser = new DOMParser();
                    const newDoc = parser.parseFromString(html, 'text/html');

                    // Atualiza o conteúdo principal
                    const newContent = newDoc.querySelector('#mainContent');
                    if (newContent) {
                        this.mainContent.innerHTML = newContent.innerHTML;
                    }

                    // Atualiza o título da página
                    const newTitle = newDoc.querySelector('title');
                    if (newTitle) {
                        document.title = newTitle.textContent;
                    }

                    // Atualiza o histórico do browser
                    if (pushState) {
                        window.history.pushState({}, '', url);
                    }

                    // Atualiza o estado ativo dos links do sidebar
                    this.updateActiveRouteImproved();

                    // Fade in da nova página
                    this.mainContent.classList.remove('page-fade-out');
                    this.overlay.classList.remove('active');

                    // Scroll para o topo
                    window.scrollTo(0, 0);

                    // Reexecuta scripts se necessário
                    this.executeScripts();

                } catch (error) {
                    console.error('Erro na transição:', error);
                    // Em caso de erro, navega normalmente
                    window.location.href = url;
                } finally {
                    this.isTransitioning = false;
                }
            }

            executeScripts() {
                // Reexecuta scripts necessários para a nova página
                const scripts = this.mainContent.querySelectorAll('script');
                scripts.forEach(script => {
                    const newScript = document.createElement('script');
                    newScript.textContent = script.textContent;
                    script.parentNode.replaceChild(newScript, script);
                });
            }
        }

        // Inicializa o sistema de transição
        document.addEventListener('DOMContentLoaded', () => {
            new PageTransition();
        });

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
