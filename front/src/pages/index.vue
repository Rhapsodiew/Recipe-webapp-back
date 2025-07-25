<template>
  <v-container>
    <v-card>
      <v-card-text>
        <v-select
          clearable
          label="Filtre Ingrédient"
          :items="ingredients"
          v-model="selectedIngredient"
        ></v-select>

        <div class="d-flex justify-center">
          <v-btn color="green" @click="openCreateForm">Ajouter une recette</v-btn>
        </div>
        <v-dialog v-model="formCreateVisibility" persistent max-width="600px">
          <v-card>
            <v-card-title>Ajouter une recette</v-card-title>
            <v-card-text>
              <v-text-field v-model="formData.name" label="Nom de la recette" />
              <v-select
                v-model="formData.ingredients"
                :items="ingredients"
                label="Ingrédients"
                multiple
              ></v-select>
            </v-card-text>
            <v-card-actions>
              <v-btn color="primary" @click="submitCreateForm">Enregistrer</v-btn>
              <v-btn text @click="formCreateVisibility = false">Annuler</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <RecipeDashboard
          :recipes="recipes"
          @updateRecipe="openUpdateForm"
          @deleteRecipe="deleteRecipe"
        />
        <v-dialog v-model="formUpdateVisibility" persistent max-width="600px">
          <v-card>
            <v-card-title>Modifier la recette</v-card-title>
            <v-card-text>
              <v-text-field v-model="formData.name" label="Nom de la recette" />
              <v-select
                v-model="formData.ingredients"
                :items="ingredients"
                label="Ingrédients"
                multiple
              ></v-select>
            </v-card-text>
            <v-card-actions>
              <v-btn color="primary" @click="submitUpdateForm">Enregistrer</v-btn>
              <v-btn text @click="formUpdateVisibility = false">Annuler</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

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

const formUpdateVisibility = ref(false)
const formCreateVisibility = ref(false)
const formData = ref({ name: '', ingredients: [] })
// open update form
function openUpdateForm(recipe) {
  formData.value = {
    id: recipe.id,
    name: recipe.name,
    ingredients: recipe.ingredients.map(ingredient => ingredient.name)
  }
  formUpdateVisibility.value = true
}

// open create form
function openCreateForm() {
  formData.value = {
    name: '',
    ingredients: []
  }
  formCreateVisibility.value = true
}

// Submit create recipe
async function submitCreateForm() {
  await axios.post('http://localhost:8000/api/recipes', {
    name: formData.value.name,
    ingredients: formData.value.ingredients.map(ingredient => ({ name: ingredient }))
  })
  formCreateVisibility.value = false
  fetchRecipes()
}

// Submit update recipe
async function submitUpdateForm() {
  await axios.put(`http://localhost:8000/api/recipes/${formData.value.id}`, {
    name: formData.value.name,
    ingredients: formData.value.ingredients.map(ingredient => ({ name: ingredient }))
  })
  formUpdateVisibility.value = false
  fetchRecipes()
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