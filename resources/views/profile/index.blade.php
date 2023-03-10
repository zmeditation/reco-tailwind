<x-app-layout>
	<x-slot name="header">
		<div class="flex items-center justify-between w-full">
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				{{ __('profile.header.edit_title') }}
			</h2>
		</div>
	</x-slot>

	<div class="py-12">
		<div class="w-full lg:max-w-[90%] xl:max-w-[80%] mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<!-- profile edit -->
				<div class="max-w-xl">
					<livewire:profile.edit/>
				</div>
			</div>

			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<!-- password update -->
				<div class="max-w-xl">
					<livewire:profile.password-update/>
				</div>
			</div>

			<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
				<!-- delete user -->
				<div class="max-w-xl">
					<livewire:profile.delete-user/>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
