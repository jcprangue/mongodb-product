<template>
  <div>
    <table class="w-full my-4 whitespace-no-wrap bg-white">
      <tr class="font-bold text-left">
        <th class="p-4" width="50">#</th>
        <th class="p-4" width="250">User</th>
        <th class="p-4" width="250">User Action</th>
        <th class="p-4" width="350">Date Modified</th>
        
      </tr>

      <tr
        v-for="(row, i) of record"
        :key="row.id"
        class="border-t hover:bg-gray-100 focus-within:bg-gray-100"
      >
        <td class="p-3">
          {{ +i + 1 }}
        </td>
        <td class="p-3">
          {{ row.users.name }}
        </td>
        <td class="p-3">
          {{ row.action }}
        </td>
        <td class="p-3">
          {{ row.created_at }}
        </td>
       
        
      </tr>
    </table>
  </div>
</template>

<script>
import Icon from "@/Shared/Icon";

export default {
  components: {
    Icon,
  },
  props: {
    record: {
      type: [Array, Object],
      default: () => {},
    },
    
  },
  data() {
    return {
     
    };
  },
  mounted(){
    console.log(this.record)
  }
  
};
</script>
