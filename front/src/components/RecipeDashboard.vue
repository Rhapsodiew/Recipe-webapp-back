<template>
    <v-table>
        <thead>
            <tr>
                <th>Nom de la recette</th>
                <th>Ingredients</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="recipe in recipes" :key="recipe.id"
            @click="$emit('updateRecipe', recipe)"
            style="cursor: pointer;">
                <td>{{ recipe.name }}</td>
                <td>
                    <ul>
                        <li v-for="ingredient in recipe.ingredients" :key="ingredient.id">
                            {{ ingredient.name }}
                        </li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </v-table>
</template>

<script setup>

defineProps({
    recipes: Array
})
defineEmits(['updateRecipe'])
</script>