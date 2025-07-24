<template>
  <v-container>
    <v-card>
      <v-card-text>
        <v-select
          label="Filtre Ingrédient"
          :items="ingredients"
          v-model="selectedIngredient"
        ></v-select>
        <RecipeDashboard
          :recipes="recipes"
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
const ingredients = ref([])
const selectedIngredient = ref(null)

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

// Fetch ingredients
async function fetchIngredients() {
  try {
    const res = await axios.get('http://localhost:8000/api/ingredients')
    ingredients.value = res.data.map(e => e.name)
  } catch (err) {
    console.error(err)
  }
}

// Fetch recipes
async function fetchRecipes() {
  try {
    let url = 'http://localhost:8000/api/recipes'
    if (selectedIngredient.value) {
      url += `/search?ingredient=${selectedIngredient.value}`
    }
    const res = await axios.get(url)
    recipes.value = res.data
  } catch (err) {
    console.error(err)
  }
}

onMounted(async () => {
  await fetchIngredients()
  await fetchRecipes()
})

watch(selectedIngredient, fetchRecipes)
</script>