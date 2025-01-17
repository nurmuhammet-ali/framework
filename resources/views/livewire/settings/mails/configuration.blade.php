<div class="py-6 sm:px-8 sm:py-10 max-w-2xl mx-auto">
    <div class="space-y-8 divide-y divide-gray-200 dark:divide-gray-700">
        <div>
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    {{ __('Account Configuration') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __("Setup the account used to send email to customers or admins. Don't share these informations") }}
                </p>
            </div>
            <div class="mt-6 grid gap-4 grid-cols-6 sm:gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <x-shopper-input.group for="mail_from_name" label="Sender name" :error="$errors->first('mail_from_name')" isRequired>
                        <x-shopper-input.text type='text' wire:model='mail_from_name' autocomplete='off' id='mail_from_name' />
                    </x-shopper-input.group>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-shopper-input.group for="mail_from_address" label="Sender email" :error="$errors->first('mail_from_address')" isRequired>
                        <x-shopper-input.text type='text' wire:model='mail_from_address' autocomplete='off' id='mail_from_address' />
                    </x-shopper-input.group>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-shopper-input.group for="mail_username" label="Username">
                        <x-shopper-input.text type='text' wire:model='mail_username' autocomplete='off' id='mail_username' />
                    </x-shopper-input.group>
                </div>

                <div class="col-span-6 sm:col-span-3">
                    <x-shopper-input.group for="mail_password" label="Password">
                        <x-shopper-input.text type='text' wire:model='mail_password' autocomplete='off' id='mail_password' />
                    </x-shopper-input.group>
                </div>
            </div>
        </div>
        <div class="pt-8">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    {{ __('Server Configuration') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __("Information related to the mail server you are going to use and the associated protocol. For more information") }}
                    <a href="https://laravel.com/docs/mail#introduction" target="_blank" class="text-blue-600 hover:text-blue-500 hover:underline dark:text-blue-500">{{ __('visit the documentation.') }}</a>
                </p>
            </div>
            <div class="mt-6 grid gap-4 grid-cols-6 sm:gap-6">
                <x-shopper-input.group for="mail_mailer" label="Mail method" class="col-span-6 sm:col-span-3">
                    <x-shopper-input.select wire:model="mail_mailer" id="mail_mailer">
                        <option value="smtp">SMTP</option>
                        <option value="sendmail">Sendmail</option>
                        <option value="mailgun">Mailgun</option>
                        <option value="mandrill">Mandrill</option>
                    </x-shopper-input.select>
                </x-shopper-input.group>

                <x-shopper-input.group for="mail_host" label="Mail host" class="col-span-6 sm:col-span-3">
                    <x-shopper-input.text type='text' wire:model='mail_host' autocomplete='off' id='mail_host' />
                </x-shopper-input.group>

                <x-shopper-input.group for="mail_port" label="Mail port" class="col-span-6 sm:col-span-3">
                    <x-shopper-input.text type='text' wire:model='mail_port' autocomplete='off' id='mail_port' />
                </x-shopper-input.group>

                <x-shopper-input.group for="mail_encryption" label="Encryption protocol" class="col-span-6 sm:col-span-3">
                    <x-shopper-input.select wire:model="mail_encryption" id="mail_encryption">
                        <option value="">{{ __('No encryption') }}</option>
                        <option value="tls">TLS</option>
                        <option value="ssl">SSL</option>
                    </x-shopper-input.select>
                </x-shopper-input.group>
            </div>
        </div>
    </div>
    <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700">
        <div class="flex justify-end">
            <x-shopper-button wire:click="store" type="button" wire:loading.attr="disabled">
                <x-shopper-loader wire:loading wire:target="store" />
                {{ __('Save') }}
            </x-shopper-button>
        </div>
    </div>
</div>
