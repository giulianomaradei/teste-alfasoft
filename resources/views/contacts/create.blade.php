@extends('layouts.app')

@section('title', 'Novo Contato')
@section('header', 'Novo Contato')

@section('content')
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('contacts.index') }}"
                class="inline-flex items-center rounded-lg border border-gray-300 px-3 py-2 sm:px-4 text-sm sm:text-base transition-colors hover:bg-gray-50 page-link">
                <i class="fas fa-arrow-left mr-2"></i>
                <span class="hidden sm:inline">Voltar à Lista</span>
                <span class="sm:hidden">Voltar</span>
            </a>
        </div>

        <!-- Form Card -->
        <div class="rounded-lg bg-white shadow-md">
            <div class="border-b border-gray-200 p-4 sm:p-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Adicionar Novo Contato</h2>
            </div>

            <div class="p-4 sm:p-6">
                <form method="POST" action="{{ route('contacts.store') }}" class="space-y-6" id="contactForm">
                    @csrf

                    <!-- Name and Email Row -->
                    <div class="grid grid-cols-1 gap-4 sm:gap-6 md:grid-cols-2">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                class="@error('name') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-3 py-3 sm:py-2 text-base sm:text-sm transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="Digite o nome completo">
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                class="@error('email') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-3 py-3 sm:py-2 text-base sm:text-sm transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                placeholder="exemplo@email.com">
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Field -->
                    <div class="space-y-2">
                        <label for="contact" class="block text-sm font-medium text-gray-700">Contato *</label>
                        <input type="text" id="contact" name="contact" value="{{ old('contact') }}" required
                            maxlength="9" pattern="[0-9]{9}"
                            class="@error('contact') border-red-500 @enderror w-full rounded-lg border border-gray-300 px-3 py-3 sm:py-2 text-base sm:text-sm transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                            placeholder="123456789">
                        <p class="text-sm text-gray-500">Digite apenas números (9 dígitos)</p>
                        @error('contact')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center sm:justify-end pt-4">
                        <button type="submit" id="submitButton"
                            class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-blue-600 px-6 py-3 sm:py-2 text-base sm:text-sm font-medium text-white transition-colors hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
                            <i class="fas fa-save mr-2" id="saveIcon"></i>
                            <svg class="-ml-1 mr-2 hidden h-4 w-4 animate-spin text-white" id="loadingIcon" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span id="buttonText">Salvar Contato</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Card -->
        <div class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle mr-3 mt-0.5 text-blue-600 flex-shrink-0"></i>
                <div class="flex-1">
                    <h3 class="font-medium text-blue-900">Informações importantes:</h3>
                    <ul class="mt-2 space-y-1 text-sm text-blue-700">
                        <li>• Nome deve ter mais de 5 caracteres</li>
                        <li>• Contato deve ter exatamente 9 dígitos</li>
                        <li>• Email deve ser válido e único</li>
                        <li>• Contato deve ser único</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('contactForm');
            const submitButton = document.getElementById('submitButton');
            const saveIcon = document.getElementById('saveIcon');
            const loadingIcon = document.getElementById('loadingIcon');
            const buttonText = document.getElementById('buttonText');
            const nameField = document.getElementById('name');
            const emailField = document.getElementById('email');
            const contactField = document.getElementById('contact');

            // Handle form submission
            form.addEventListener('submit', function(e) {
                // Show loading state
                submitButton.disabled = true;
                saveIcon.classList.add('hidden');
                loadingIcon.classList.remove('hidden');
                buttonText.textContent = 'Salvando...';

                // Change button color to indicate loading
                submitButton.classList.remove('hover:bg-blue-700');
                submitButton.classList.add('bg-blue-500');
            });

            // Auto-format contact field
            contactField.addEventListener('input', function() {
                this.value = this.value.replace(/\D/g, '');
            });

            // Real-time validation
            nameField.addEventListener('input', function() {
                if (this.value.length < 6) {
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
        });
    </script>
@endsection
