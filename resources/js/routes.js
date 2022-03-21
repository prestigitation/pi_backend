export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/audiences', component: require('./components/Audience.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/user/roles', component: require('./components/UserRoles.vue').default },
    { path: '/teachers', component: require('./components/Teachers.vue').default },
    { path: '/directions', component: require('./components/Directions.vue').default },
    { path: '/schedule', component: require('./components/Schedule.vue').default },
    { path: '/news', component: require('./components/News.vue').default },
    { path: '/study_variants', component: require('./components/layout/StudyVariantCreate.vue').default },
    { path: '/groups', component: require('./components/Groups.vue').default },
    { path: '/foreign_teachers', component: require('./components/ForeignTeachers.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default },
];