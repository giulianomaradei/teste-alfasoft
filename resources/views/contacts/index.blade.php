@extends('layouts.app')

@section('title', 'Lista de Contatos')
@section('header', 'Contatos')

@section('content')
    <div>
        <!-- Header Section -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1">
                    <h1 class="mb-2 text-2xl sm:text-3xl font-bold text-gray-900">Contatos</h1>
                    <p class="text-sm sm:text-base text-gray-600">
                        {{ $contacts->count() }} {{ $contacts->count() === 1 ? 'contato' : 'contatos' }} cadastrados
                    </p>
                </div>
                @auth
                    <div class="flex-shrink-0">
                        <a href="{{ route('contacts.create') }}"
                            class="flex w-full sm:w-auto items-center justify-center rounded-lg bg-blue-600 px-4 py-3 sm:py-2 text-sm sm:text-base font-medium text-white transition-colors hover:bg-blue-700 page-link">
                            <i class="fas fa-user-plus mr-2"></i>
                            Novo Contato
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative w-full sm:max-w-md">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 transform text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Buscar contatos..."
                    class="w-full rounded-lg border border-gray-300 py-3 sm:py-2 pl-10 pr-4 text-base sm:text-sm transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <!-- Content Area -->
        <div id="contactsContainer">
            @if ($contacts->isEmpty())
                <!-- Empty State -->
                <div class="py-12 text-center">
                    <i class="fas fa-user-plus mb-4 text-6xl text-gray-400"></i>
                    <h3 class="mb-2 text-lg font-medium text-gray-900">Nenhum contato cadastrado</h3>
                    <p class="mb-4 text-gray-600">Comece adicionando seu primeiro contato.</p>
                    @auth
                        <a href="{{ route('contacts.create') }}"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors hover:bg-blue-700 page-link">
                            <i class="fas fa-user-plus mr-2"></i>
                            Adicionar Contato
                        </a>
                    @else
                        <p class="text-gray-500">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 page-link">Faça login</a>
                            para adicionar contatos.
                        </p>
                    @endauth
                </div>
            @else
                <!-- Contacts Grid -->
                <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($contacts as $contact)
                        <div class="contact-card overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-shadow hover:shadow-md">
                            <div class="p-4 sm:p-6">
                                <!-- Header with Avatar and Actions -->
                                <div class="mb-4 flex items-start justify-between">
                                    <!-- Avatar and Name -->
                                    <div class="flex items-center">
                                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-base font-medium text-gray-900 break-words">{{ $contact->name }}</h3>
                                        </div>
                                    </div>

                                    <!-- Actions Dropdown -->
                                    <div class="relative flex-shrink-0" x-data="{ open: false }">
                                        <button @click="open = !open"
                                                class="rounded-lg p-2 transition-colors hover:bg-gray-100">
                                            <i class="fas fa-ellipsis-v text-gray-400"></i>
                                        </button>

                                        <div x-show="open"
                                             @click.away="open = false"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 top-full z-10 mt-2 w-48 rounded-lg bg-white shadow-lg ring-1 ring-gray-200">
                                            <div class="py-1">
                                                <a href="{{ route('contacts.show', $contact) }}"
                                                   class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-blue-50 hover:text-blue-700 page-link">
                                                    <i class="fas fa-eye mr-3 h-4 w-4"></i>
                                                    Ver detalhes
                                                </a>

                                                @auth
                                                    <a href="{{ route('contacts.edit', $contact) }}"
                                                       class="flex items-center px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-green-50 hover:text-green-700 page-link">
                                                        <i class="fas fa-edit mr-3 h-4 w-4"></i>
                                                        Editar
                                                    </a>

                                                    <hr class="my-1 border-gray-100">

                                                    <button type="button"
                                                            onclick="openDeleteModal({{ $contact->id }}, '{{ addslashes($contact->name) }}')"
                                                            class="flex w-full items-center px-4 py-2 text-sm text-red-600 transition-colors hover:bg-red-50">
                                                        <i class="fas fa-trash mr-3 h-4 w-4"></i>
                                                        Excluir
                                                    </button>

                                                    <!-- Hidden Delete Form -->
                                                    <form method="POST" action="{{ route('contacts.destroy', $contact) }}"
                                                          class="hidden" id="deleteForm-{{ $contact->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="space-y-2">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-envelope mr-2 h-4 w-4 flex-shrink-0"></i>
                                        <span class="text-sm break-words">{{ $contact->email }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-phone mr-2 h-4 w-4 flex-shrink-0"></i>
                                        <span class="text-sm">{{ $contact->contact }}</span>
                                    </div>
                                </div>

                                <!-- Created At -->
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <p class="text-xs text-gray-500">
                                        Criado em {{ $contact->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @auth
        <!-- Delete Modal -->
        <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 px-4">
            <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Confirmar Exclusão</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Tem certeza que deseja excluir o contato <span id="deleteContactName" class="font-medium"></span>?
                        Esta ação não pode ser desfeita.
                    </p>
                </div>
                <div class="flex justify-end gap-3">
                    <button onclick="closeDeleteModal()"
                            class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button onclick="confirmDelete()"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700">
                        Excluir
                    </button>
                </div>
            </div>
        </div>
    @endauth

    <script>
        let deleteContactId = null;

        function openDeleteModal(contactId, contactName) {
            deleteContactId = contactId;
            document.getElementById('deleteContactName').textContent = contactName;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            deleteContactId = null;
        }

        function confirmDelete() {
            if (deleteContactId) {
                document.getElementById('deleteForm-' + deleteContactId).submit();
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const contactCards = document.querySelectorAll('.contact-card');

            contactCards.forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const email = card.querySelector('.fas.fa-envelope').nextElementSibling.textContent.toLowerCase();
                const phone = card.querySelector('.fas.fa-phone').nextElementSibling.textContent.toLowerCase();

                if (name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
@endsection
