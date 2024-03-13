import { Store } from 'vuex'
import Cookies from 'js-cookie'

declare module '@vue/runtime-core' {
  // declare your own store states
  interface State {
    isAuthenticated: boolean
    authUser: object,
    loggingOut: boolean,
    superAdmin: boolean,
  }

  // provide typings for `this.$store`
  interface ComponentCustomProperties {
    $store: Store<State>
  }

  export interface ComponentCustomProperties {
    $goto: any
}
}
