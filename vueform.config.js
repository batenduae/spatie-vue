import en from '@vueform/vueform/locales/en'
import tailwind from '@vueform/vueform/dist/tailwind'
import {defineConfig} from '@vueform/vueform'
import PluginMask from '@vueform/plugin-mask'

export default defineConfig({
    theme: tailwind,
    locales: {en},
    locale: 'en',
    plugins: [
        PluginMask,
    ]
})
