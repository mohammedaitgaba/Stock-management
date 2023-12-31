<script setup>
const tabs = [
  { name: 'Products', href: '/', current: true },
  { name: 'Recipes', href: '/recipes', current: false },
]
</script>

<template>
  <main class="fullscreen-bg">
    <div class="fixed top-0 left-0 w-full h-screen object-cover bg-center -z-10 blur-sm">
      <img src="../assets/backgrounds/homeBg.jpg" class="w-full h-full">
    </div>
    <div class="flex justify-center items-center z-10 py-5">
      <div class="border-b border-gray-200 text-xl">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
          <a v-for="tab in tabs" :key="tab.name" :href="tab.href" :class="[tab.current ? 'border-indigo-500 text-blue-200' : 'border-transparent text-black hover:border-gray-300 hover:text-gray-700', 'whitespace-nowrap border-b-2 py-4 px-1 font-medium']" :aria-current="tab.current ? 'page' : undefined">{{ tab.name }}</a>
        </nav>
      </div>
    </div>
    <div class="flex w-full  h-fit p-10 justify-center items-center">
      <slot/>
    </div>
  </main>
</template>

<style scoped>
</style>