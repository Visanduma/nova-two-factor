Nova.booting((Vue) => {
  Nova.inertia("NovaTwoFactor",require('./components/Tool').default)
  Nova.inertia("NovaTwoFactor.Prompt",require('./components/Prompt').default)
})
