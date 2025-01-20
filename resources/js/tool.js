import RegisterPage from './components/Register.vue'
import SettingsPage from './components/Settings.vue'
import PromptPage from './components/Prompt.vue'
import ClearPage from './components/Clear.vue'

Nova.booting((app,store) => {
    Nova.inertia("NovaTwoFactor.Register", RegisterPage)
    Nova.inertia("NovaTwoFactor.Settings", SettingsPage)
    Nova.inertia("NovaTwoFactor.Prompt", PromptPage)
    Nova.inertia("NovaTwoFactor.Clear", ClearPage)
})
