<template>
<div>
  <div v-if="$store.state.user">
  <div>
      <!--========== ADMIN SIDE MENU one ========-->
      <div class="_1side_menu" >
        <div class="_1side_menu_logo">
          <h3 style="text-align:center;">Logo Image</h3>
          <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
        </div>

        <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
        <div class="_1side_menu_content">
          <div class="_1side_menu_img_name">
            <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
            <p class="_1side_menu_name">Admin</p>
          </div>

          <!--~~~ MENU LIST ~~~~~~-->
          <div class="_1side_menu_list">
            <ul class="_1side_menu_list_ul">
              <li><router-link to="/home"><Icon type="ios-home-outline" /> Home</router-link></li>
              <li><router-link to="/tags"> <Icon type="ios-grid-outline" /> Tags</router-link></li>
              <li><router-link to="/categories"> <Icon type="ios-speedometer-outline" /> Categories</router-link></li>
              <li><router-link to="/users"> <Icon type="ios-person-outline" /> Users</router-link></li>
              <li><a href="/logout"> <Icon type="ios-exit-outline" /> Logout</a></li>



            </ul>
          </div>
        </div>
      </div>
      <!--========== ADMIN SIDE MENU ========-->

      <!--========= HEADER ==========-->
      <div class="header">
        <div class="_2menu _box_shadow">
          <div class="_2menu_logo">
            <ul class="open_button">
              <li>
                <Icon type="ios-list" />
              </li>
              <!--<li><Icon type="ios-albums" /></li>-->
            </ul>
          </div>
        </div>
      </div>
      <!--========= HEADER ==========-->
    </div>
    	

      </div>

<router-view/>
</div>

</template>

<script>
export default {

  props:['user'],
  data(){
    return{
      loggedIn:false,
    }
  },
  created(){
    this.$store.commit('setUser',this.user)
  }

}
</script>