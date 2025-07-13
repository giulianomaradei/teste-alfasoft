@extends('layouts.app')

@section('title', 'Detalhes do Contato')
@section('header', 'Detalhes do Contato')

@section('content')
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('contacts.index') }}"
                class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-2 sm:px-4 text-sm sm:text-base transition-colors hover:bg-gray-50 page-link">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="hidden sm:inline">Voltar à Lista</span>
                <span class="sm:hidden">Voltar</span>
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <div class="rounded-lg bg-white shadow-md">
                    <!-- Header -->
                    <div class="border-b border-gray-200 p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                            <div class="flex-1 min-w-0">
                                <h2 class="mb-2 text-2xl sm:text-3xl font-bold text-gray-900 break-words">{{ $contact->name }}</h2>
                                <p class="text-base sm:text-lg text-gray-600">ID: {{ $contact->id }}</p>
                            </div>
                            <div class="flex gap-2 mt-4 sm:mt-0 sm:ml-4">
                                <!-- Mobile Layout (Stacked) -->
                                <div class="flex flex-col gap-2 w-full sm:hidden">
                                    <a href="{{ route('contacts.edit', $contact) }}"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm transition-colors hover:border-green-300 hover:bg-green-50 page-link">
                                        <i class="fas fa-edit mr-2"></i>
                                        Editar
                                    </a>
                                    <button type="button" id="deleteBtn"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-4 py-2 text-sm text-red-600 transition-colors hover:border-red-300 hover:bg-red-50">
                                        <i class="fas fa-trash mr-2"></i>
                                        Excluir
                                    </button>
                                </div>

                                <!-- Desktop Layout -->
                                <div class="hidden sm:flex sm:gap-2">
                                    <a href="{{ route('contacts.edit', $contact) }}"
                                        class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-2 text-sm transition-colors hover:border-green-300 hover:bg-green-50 page-link">
                                        <i class="fas fa-edit mr-2"></i>
                                        Editar
                                    </a>
                                    <button type="button" id="deleteBtn"
                                        class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-2 text-sm text-red-600 transition-colors hover:border-red-300 hover:bg-red-50">
                                        <i class="fas fa-trash mr-2"></i>
                                        Excluir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Details -->
                    <div class="p-4 sm:p-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope mr-3 h-5 w-5 text-gray-400 flex-shrink-0"></i>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p class="text-gray-900 break-words">{{ $contact->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-phone mr-3 h-5 w-5 text-gray-400 flex-shrink-0"></i>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-500">Contato</p>
                                        <p class="text-gray-900">{{ $contact->contact }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <i class="fas fa-id-card mr-3 h-5 w-5 text-gray-400 flex-shrink-0"></i>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-500">ID</p>
                                        <p class="text-gray-900">{{ $contact->id }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-3 h-5 w-5 text-gray-400 flex-shrink-0"></i>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-500">Nome</p>
                                        <p class="text-gray-900 break-words">{{ $contact->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <div class="rounded-lg bg-white shadow-md">
                    <div class="border-b border-gray-200 p-4 sm:p-6">
                        <h3 class="flex items-center text-lg font-semibold text-gray-900">
                            <i class="fas fa-calendar mr-2"></i>
                            Informações
                        </h3>
                    </div>
                    <div class="space-y-4 p-4 sm:p-6">
                        <div>
                            <p class="text-sm text-gray-500">Criado em</p>
                            <p class="text-gray-900">
                                {{ $contact->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Última atualização</p>
                            <p class="text-gray-900">
                                {{ $contact->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50 p-4">
        <div class="w-full max-w-md rounded-lg bg-white shadow-xl">
            <div class="p-6">
                <div class="mb-4 flex items-center">
                    <i class="fas fa-exclamation-triangle mr-3 text-2xl text-red-500 flex-shrink-0"></i>
                    <h3 class="text-lg font-semibold text-gray-900">Confirmar Exclusão</h3>
                </div>

                <p class="mb-6 text-sm sm:text-base text-gray-600">
                    Tem certeza que deseja excluir o contato <strong id="contactName"></strong>?
                    Esta ação não pode ser desfeita.
                </p>

                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <button type="button" id="cancelBtn"
                        class="order-2 sm:order-1 rounded-lg border border-gray-300 px-4 py-2 text-gray-600 transition-colors hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="button" id="confirmDeleteBtn"
                        class="order-1 sm:order-2 flex items-center justify-center rounded-lg bg-red-600 px-4 py-2 text-white transition-colors hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50">
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

    <!-- Hidden Delete Form -->
    <form method="POST" action="{{ route('contacts.destroy', $contact) }}" class="hidden"
        id="deleteForm-{{ $contact->id }}">
        @csrf
        @method('DELETE')
    </form>

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
            // Modal event listeners
            const deleteModal = document.getElementById('deleteModal');
            const cancelBtn = document.getElementById('cancelBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const deleteBtns = document.querySelectorAll('#deleteBtn');

            // Delete button event listeners
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    openDeleteModal({{ $contact->id }}, '{{ addslashes($contact->name) }}');
                });
            });

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
