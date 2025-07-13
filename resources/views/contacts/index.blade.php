@extends('layouts.app')

@section('title', 'Lista de Contatos')
@section('header', 'Contatos')

@section('content')
    <div>
        <!-- Header Section -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="mb-2 text-3xl font-bold text-gray-900">Contatos</h1>
                <p class="text-gray-600">
                    {{ $contacts->count() }} {{ $contacts->count() === 1 ? 'contato' : 'contatos' }} cadastrados
                </p>
            </div>
            <a href="{{ route('contacts.create') }}"
                class="flex items-center rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors hover:bg-blue-700">
                <i class="fas fa-user-plus mr-2"></i>
                Novo Contato
            </a>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative max-w-md">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 transform text-gray-400"></i>
                <input type="text" id="searchInput" placeholder="Buscar contatos..."
                    class="w-full rounded-lg border border-gray-300 py-2 pl-10 pr-4 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
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
                    <a href="{{ route('contacts.create') }}"
                        class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 font-medium text-white transition-colors hover:bg-blue-700">
                        <i class="fas fa-user-plus mr-2"></i>
                        Adicionar Contato
                    </a>
                </div>
            @else
                <!-- Contacts Grid -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3" id="contactsGrid">
                    @foreach ($contacts as $contact)
                        <div
                            class="contact-card rounded-lg border-l-4 border-l-blue-500 bg-white shadow-md transition-shadow duration-200 hover:shadow-lg">
                            <div class="p-6">
                                <!-- Header -->
                                <div class="mb-4 flex items-start justify-between">
                                    <div>
                                        <h3 class="mb-1 font-semibold text-gray-900">{{ $contact->name }}</h3>
                                        <p class="text-gray-600">ID: {{ $contact->id }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <a href="{{ route('contacts.show', $contact) }}"
                                            class="flex min-w-10 items-center justify-center rounded-lg border border-gray-300 p-2 transition-colors hover:border-blue-300 hover:bg-blue-50"
                                            title="Ver detalhes">
                                            <i class="fas fa-eye text-gray-600"></i>
                                        </a>
                                        <a href="{{ route('contacts.edit', $contact) }}"
                                            class="flex min-w-10 items-center justify-center rounded-lg border border-gray-300 p-2 transition-colors hover:border-green-300 hover:bg-green-50"
                                            title="Editar">
                                            <i class="fas fa-edit text-gray-600"></i>
                                        </a>
                                        <form method="POST" action="{{ route('contacts.destroy', $contact) }}"
                                            class="inline" id="deleteForm-{{ $contact->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="flex min-w-10 items-center justify-center rounded-lg border border-gray-300 p-2 text-red-600 transition-colors hover:border-red-300 hover:bg-red-50"
                                                title="Excluir"
                                                onclick="openDeleteModal({{ $contact->id }}, '{{ $contact->name }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="space-y-2">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-envelope mr-2 h-4 w-4"></i>
                                        <span class="">{{ $contact->email }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-phone mr-2 h-4 w-4"></i>
                                        <span class="">{{ $contact->contact }}</span>
                                    </div>
                                </div>

                                <!-- Created At -->
                                <div class="mt-4 border-t border-gray-100 pt-4">
                                    <p class="text-gray-500">
                                        Criado em {{ $contact->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- No Search Results State -->
        <div id="noResults" class="hidden py-12 text-center">
            <i class="fas fa-search mb-4 text-6xl text-gray-400"></i>
            <h3 class="mb-2 text-lg font-medium text-gray-900">Nenhum contato encontrado</h3>
            <p class="mb-4 text-gray-600">Tente ajustar os termos da busca.</p>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
        <div class="mx-4 w-full max-w-md rounded-lg bg-white shadow-xl">
            <div class="p-6">
                <div class="mb-4 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3 text-2xl text-red-500"></i>
                    <h3 class="text-lg font-semibold text-gray-900">Confirmar Exclusão</h3>
                </div>

                <p class="mb-6 text-gray-600">
                    Tem certeza que deseja excluir o contato <strong id="contactName"></strong>?
                    Esta ação não pode ser desfeita.
                </p>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="cancelBtn"
                        class="rounded-lg border border-gray-300 px-4 py-2 text-gray-600 transition-colors hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="button" id="confirmDeleteBtn"
                        class="flex items-center rounded-lg bg-red-600 px-4 py-2 text-white transition-colors hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50">
                        <i class="fas fa-trash mr-2" id="modalDeleteIcon"></i>
                        <svg class="-ml-1 mr-2 hidden h-4 w-4 animate-spin text-white" id="modalLoadingIcon" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span id="modalButtonText">Excluir</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentContactId = null;

        function openDeleteModal(contactId, contactName) {
            currentContactId = contactId;
            document.getElementById('contactName').textContent = contactName;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            currentContactId = null;

            // Reset modal button state
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            const modalDeleteIcon = document.getElementById('modalDeleteIcon');
            const modalLoadingIcon = document.getElementById('modalLoadingIcon');
            const modalButtonText = document.getElementById('modalButtonText');

            confirmBtn.disabled = false;
            modalDeleteIcon.classList.remove('hidden');
            modalLoadingIcon.classList.add('hidden');
            modalButtonText.textContent = 'Excluir';
            confirmBtn.classList.remove('bg-red-500');
            confirmBtn.classList.add('bg-red-600', 'hover:bg-red-700');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const contactsContainer = document.getElementById('contactsContainer');
            const contactsGrid = document.getElementById('contactsGrid');
            const noResults = document.getElementById('noResults');
            const contactCards = document.querySelectorAll('.contact-card');
            const deleteModal = document.getElementById('deleteModal');
            const cancelBtn = document.getElementById('cancelBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let visibleCards = 0;

                contactCards.forEach(card => {
                    const cardText = card.textContent.toLowerCase();
                    if (cardText.includes(searchTerm)) {
                        card.style.display = 'block';
                        visibleCards++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (visibleCards === 0 && searchTerm !== '') {
                    contactsContainer.classList.add('hidden');
                    noResults.classList.remove('hidden');
                } else {
                    contactsContainer.classList.remove('hidden');
                    noResults.classList.add('hidden');
                }
            });

            // Modal event listeners
            cancelBtn.addEventListener('click', closeDeleteModal);

            // Close modal when clicking outside
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    closeDeleteModal();
                }
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !deleteModal.classList.contains('hidden')) {
                    closeDeleteModal();
                }
            });

            // Confirm delete button
            confirmDeleteBtn.addEventListener('click', function() {
                if (currentContactId) {
                    const form = document.getElementById(`deleteForm-${currentContactId}`);
                    const modalDeleteIcon = document.getElementById('modalDeleteIcon');
                    const modalLoadingIcon = document.getElementById('modalLoadingIcon');
                    const modalButtonText = document.getElementById('modalButtonText');

                    // Show loading state
                    this.disabled = true;
                    modalDeleteIcon.classList.add('hidden');
                    modalLoadingIcon.classList.remove('hidden');
                    modalButtonText.textContent = 'Excluindo...';

                    // Change button styling
                    this.classList.remove('hover:bg-red-700');
                    this.classList.add('bg-red-500');

                    // Submit the form
                    form.submit();
                }
            });
        });
    </script>
@endsection
