<template>
  <v-container>
    <v-card>
      <v-card-text>
        <RecipeDashboard :recipes="recipes" @updateRecipe="openForm" />
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

function openForm(recipe) {
  console.log(recipe)
}

const recipes = ref([])

// Fetch recipes
onMounted(async () => {
  try {
    const res = await axios.get('http://localhost:8000/api/recipes')
    recipes.value = res.data
  } catch (err) {
    console.error(err)
  }
})
</script>