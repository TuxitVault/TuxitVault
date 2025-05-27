<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-[url('/images/background.jpeg')]">
        <div class="w-full sm:max-w-md mt-6 bg-white shadow-lg shadow-green-600 sm:rounded-lg">
            <div class="flex flex-col gap-2">
                <div class="px-6 py-4 flex justify-center">
                    <slot name="logo" />
                </div>

                <div class="w-full sm:max-w-md px-6 py-4 overflow-hidden sm:rounded-lg">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
