Nova.booting((Vue) => {
    Nova.inertia("NovaTwoFactor.Register", require('./components/Register').default)
    Nova.inertia("NovaTwoFactor.Settings", require('./components/Settings').default)
    Nova.inertia("NovaTwoFactor.Prompt", require('./components/Prompt').default)
    Nova.inertia("NovaTwoFactor.Clear", require('./components/Clear').default)
})
