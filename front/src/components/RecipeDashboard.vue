<template>
    <v-table>
        <thead>
            <tr>
                <th>Nom de la recette</th>
                <th>Ingredients</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="recipe in recipes" :key="recipe.id">
                <td
                    @click="$emit('updateRecipe', recipe)"
                    style="cursor: pointer;"
                >{{ recipe.name }}</td>
                <td
                    @click="$emit('updateRecipe', recipe)"
                    style="cursor: pointer;">
                    <ul>
                        <li v-for="ingredient in recipe.ingredients" :key="ingredient.id">
                            {{ ingredient.name }}
                        </li>
                    </ul>
                </td>
                <td style="text-align: center;">
                    <v-btn icon size="small" color="error" variant="tonal"
                    @click="$emit('deleteRecipe', recipe)"
                    >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
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