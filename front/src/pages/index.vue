<template>
  <v-container>
    <v-card>
      <v-card-text>
        <RecipeDashboard :recipes="recipes"
        @updateRecipe="openForm"
        @deleteRecipe="deleteRecipe"
        />
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const recipes = ref([])

function openForm(recipe) {
  console.log(recipe)
}

// Delete recipe
async function deleteRecipe(recipe) {
  try {
    await axios.delete(`http://localhost:8000/api/recipes/${recipe.id}`)
    recipes.value = recipes.value.filter(removedRecipe => removedRecipe.id !== recipe.id)
  } catch(err) {
    console.log(err)
  }
}

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