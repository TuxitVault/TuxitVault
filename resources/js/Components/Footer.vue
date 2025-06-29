<template>
  <footer class="bg-white border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-600">
      <p>&copy; {{ new Date().getFullYear() }} Tuxitvault. Tous droits réservés.</p>
      <Link :href="route('policy')" class="text-blue-500 hover:underline mt-2 sm:mt-0">
        Conditions générales d'utilisation
      </Link>
    </div>
  </footer>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
