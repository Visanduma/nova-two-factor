Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-two-factor',
      path: '/nova-two-factor',
      component: require('./components/Tool').default,
    },
  ])
})
