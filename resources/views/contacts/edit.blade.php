@extends('layouts.app')

@section('title', 'Editar Contato')
@section('header', 'Editar Contato')

@section('content')
    <div class="mx-auto max-w-2xl">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('contacts.show', $contact) }}"
                class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 transition-colors hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar aos Detalhes
            </a>
        </div>

        <!-- Form Card -->
        <div class="rounded-lg bg-white shadow-md">
            <div class="border-b border-gray-200 p-6">
                <h2 class="text-2xl font-bold text-gray-900">Editar Contato</h2>
                <p class="mt-1 text-gray-600">Atualize as informações do contato</p>
            </div>

            <div class="p-6">
                <form method="POST" action="{{ route('contacts.update', $contact) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Name and Email Row -->
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $contact->name) }}"
                                required
                                class="@error('name') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-3 py-2 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="Digite o nome completo">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $contact->email) }}"
                                required
                                class="@error('email') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-3 py-2 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="exemplo@email.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Field -->
                    <div class="space-y-2">
                        <label for="contact" class="block text-sm font-medium text-gray-700">Contato *</label>
                        <input type="text" id="contact" name="contact" value="{{ old('contact', $contact->contact) }}"
                            required maxlength="9" pattern="[0-9]{9}"
                            class="@error('contact') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-3 py-2 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                            placeholder="123456789">
                        <p class="text-sm text-gray-500">Digite apenas números (9 dígitos)</p>
                        @error('contact')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex justify-between pt-4">
                        <div class="flex gap-3">
                            <a href="{{ route('contacts.show', $contact) }}"
                                class="inline-flex items-center rounded-lg bg-gray-500 px-6 py-2 font-medium text-white transition-colors hover:bg-gray-600">
                                <i class="fas fa-times mr-2"></i>
                                Cancelar
                            </a>
                            <button type="button" id="deleteBtn"
                                class="inline-flex items-center rounded-lg bg-red-600 px-6 py-2 font-medium text-white transition-colors hover:bg-red-700">
                                <i class="fas fa-trash mr-2"></i>
                                Excluir
                            </button>
                        </div>
                        <button type="submit" id="submitButton"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-6 py-2 font-medium text-white transition-colors hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
                            <i class="fas fa-save mr-2" id="saveIcon"></i>
                            <svg class="-ml-1 mr-2 hidden h-4 w-4 animate-spin text-white" id="loadingIcon" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span id="buttonText">Atualizar Contato</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Info Card -->
        <div class="mt-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
            <div class="flex items-start">
                <i class="fas fa-user mr-2 mt-1 text-gray-600"></i>
                <div>
                    <h3 class="font-medium text-gray-900">Informações atuais:</h3>
                    <div class="mt-1 space-y-1 text-sm text-gray-700">
                        <p><strong>ID:</strong> {{ $contact->id }}</p>
                        <p><strong>Nome:</strong> {{ $contact->name }}</p>
                        <p><strong>Email:</strong> {{ $contact->email }}</p>
                        <p><strong>Contato:</strong> {{ $contact->contact }}</p>
                        <p><strong>Criado em:</strong> {{ $contact->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Atualizado em:</strong> {{ $contact->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Card -->
        <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle mr-2 mt-1 text-blue-600"></i>
                <div>
                    <h3 class="font-medium text-blue-900">Lembrete das regras:</h3>
                    <ul class="mt-1 space-y-1 text-sm text-blue-700">
                        <li>• Nome deve ter mais de 5 caracteres</li>
                        <li>• Contato deve ter exatamente 9 dígitos</li>
                        <li>• Email deve ser válido e único</li>
                        <li>• Contato deve ser único</li>
                    </ul>
                </div>
            </div>
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
                        <svg class="-ml-1 mr-2 hidden h-4 w-4 animate-spin text-white" id="modalLoadingIcon"
                            fill="none" viewBox="0 0 24 24">
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
            // Format contact field to accept only numbers
            const contactField = document.getElementById('contact');

            contactField.addEventListener('input', function(e) {
                // Remove non-numeric characters
                e.target.value = e.target.value.replace(/[^0-9]/g, '');

                // Limit to 9 digits
                if (e.target.value.length > 9) {
                    e.target.value = e.target.value.slice(0, 9);
                }
            });

            // Add real-time validation feedback
            const form = document.querySelector('form');
            const nameField = document.getElementById('name');
            const emailField = document.getElementById('email');
            const submitButton = document.getElementById('submitButton');
            const saveIcon = document.getElementById('saveIcon');
            const loadingIcon = document.getElementById('loadingIcon');
            const buttonText = document.getElementById('buttonText');

            // Remove errors when user starts typing
            nameField.addEventListener('input', function() {
                // Remove border error styling
                this.classList.remove('border-red-500');

                // Hide error message
                const errorMessage = this.parentElement.querySelector('.text-red-500');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            });

            emailField.addEventListener('input', function() {
                // Remove border error styling
                this.classList.remove('border-red-500');

                // Hide error message
                const errorMessage = this.parentElement.querySelector('.text-red-500');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            });

            contactField.addEventListener('input', function(e) {
                // Remove border error styling
                this.classList.remove('border-red-500');

                // Hide error message
                const errorMessage = this.parentElement.querySelector('.text-red-500');
                if (errorMessage) {
                    errorMessage.style.display = 'none';
                }
            });

            // Form submission loading state
            form.addEventListener('submit', function(e) {
                // Prevent multiple submissions by disabling the button immediately
                submitButton.disabled = true;

                // Show loading state
                saveIcon.classList.add('hidden');
                loadingIcon.classList.remove('hidden');
                buttonText.textContent = 'Atualizando...';

                // Change button color to indicate loading
                submitButton.classList.remove('hover:bg-blue-700');
                submitButton.classList.add('bg-blue-500');
            });

            nameField.addEventListener('blur', function() {
                if (this.value.length <= 5) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            emailField.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(this.value)) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            contactField.addEventListener('blur', function() {
                if (this.value.length !== 9) {
                    this.classList.add('border-red-500');
                } else {
                    this.classList.remove('border-red-500');
                }
            });

            // Modal event listeners
            const deleteModal = document.getElementById('deleteModal');
            const cancelBtn = document.getElementById('cancelBtn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const deleteBtn = document.getElementById('deleteBtn');

            // Delete button event listener
            deleteBtn.addEventListener('click', function() {
                openDeleteModal({{ $contact->id }}, '{{ addslashes($contact->name) }}');
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
