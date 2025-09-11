<div class="flex justify-start items-center space-x-2.5 mt-8">

    <button @click="prevPage()" :disabled="currentPage === 1"
            class="flex items-center justify-center w-8 h-8 rounded-sm border border-indigo-700 text-gray-300 transition-colors hover:bg-gray-800 disabled:opacity-40 disabled:cursor-not-allowed">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <template x-for="i in totalPages" :key="i">
        <button @click="goToPage(i)"
                :class="{ 'bg-indigo-600 border-indigo-600 text-white': currentPage === i, 'border-indigo-700 text-gray-300 hover:bg-gray-800': currentPage !== i }"
                class="flex items-center justify-center w-8 h-8 rounded-sm border text-sm font-medium transition-colors">
            <span x-text="i"></span>
        </button>
    </template>

    <button @click="nextPage()" :disabled="currentPage === totalPages"
            class="flex items-center justify-center w-8 h-8 rounded-sm border border-indigo-700 text-gray-300 transition-colors hover:bg-gray-800 disabled:opacity-40 disabled:cursor-not-allowed">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>
</div>
