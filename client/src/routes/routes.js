import products from '../Pages/products.vue';
import recipes from '../Pages/recipes.vue';

const routes = [
    {
        path: '/',
        name: 'Products',
        component: products,
    },
    {
        path: '/recipes',
        name: 'Recipes',
        component: recipes,
    },
];

export default routes;