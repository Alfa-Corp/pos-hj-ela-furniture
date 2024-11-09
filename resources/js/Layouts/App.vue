<template>
  <div class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed" id="sidebar">

        <div class="c-sidebar-brand d-lg-down-none" style="background: #2181ad;">
            <img src="/images/cash-machine.png" class="bg-light rounded shadow-sm p-1" width="35"> <span class="ml-2 font-weight-bold">Sistem Kasir</span>
        </div>

        <!-- sidebar -->
        <Sidebar />
        <!-- end sidebar -->

    </div>
    <div class="c-wrapper c-fixed-components">

      <!-- header -->
      <Header />
      <!-- end header -->

      <div class="c-body">

        <!-- content -->
        <slot />
        <!-- end content -->

        <footer class="c-footer">
          <div><strong>Sistem Kasir Hj Ela Furniture</strong> &copy; 2025 - Hj Ela Furniture</div>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>

  import Header from '../Components/Header.vue'
  import Sidebar from '../Components/Sidebar.vue'

  export default {

    //register components
    components: {
      Header,
      Sidebar
    }

  }
</script>

<style>
</style>
