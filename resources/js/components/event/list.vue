<template>
  <div>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Danh sách sự kiện</h4>
            <vs-button
              type="gradient"
              style="float:right;"
              :disabled="!$hasPermission('website.update')"
              @click="$goIfAllowed('website.update', { name: 'addEvent' }, 'Bạn không có quyền thêm mới sự kiện.')"
            >Thêm mới</vs-button>
            <vs-input icon="search" placeholder="Tìm theo tiêu đề" v-model="keyword" @keyup="search" />
            <vs-table stripe :data="list" max-items="10" pagination>
              <template slot="thead">
                <vs-th>Ảnh</vs-th>
                <vs-th>Tiêu đề</vs-th>
                <vs-th>Ngày</vs-th>
                <vs-th>Thời gian</vs-th>
                <vs-th>Địa điểm</vs-th>
                <vs-th>Trạng thái</vs-th>
                <vs-th>Hành động</vs-th>
              </template>
              <template slot-scope="{data}">
                <vs-tr :key="tr.id" v-for="tr in data">
                  <vs-td>
                    <img v-if="tr.image" :src="tr.image" alt="" style="width:80px;height:54px;object-fit:cover;border-radius:6px;" />
                  </vs-td>
                  <vs-td>{{ tr.title }}</vs-td>
                  <vs-td>{{ formatDate(tr.event_date) }}</vs-td>
                  <vs-td>{{ tr.event_time }}</vs-td>
                  <vs-td>{{ tr.location }}</vs-td>
                  <vs-td>
                    <span :class="Number(tr.status) === 1 ? 'badge badge-success' : 'badge badge-secondary'">
                      {{ Number(tr.status) === 1 ? 'Hiện' : 'Ẩn' }}
                    </span>
                  </vs-td>
                  <vs-td>
                    <router-link :to="{ name: 'editEvent', params: { id: tr.id } }">
                      <vs-button vs-type="gradient" size="lagre" color="success" icon="edit"></vs-button>
                    </router-link>
                    <vs-button
                      vs-type="gradient"
                      size="lagre"
                      color="red"
                      icon="delete_forever"
                      :disabled="!$hasPermission('website.delete')"
                      @click="confirmDestroy(tr.id)"
                    ></vs-button>
                  </vs-td>
                </vs-tr>
              </template>
            </vs-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  data() {
    return {
      list: [],
      keyword: "",
      id_item: "",
      timer: null,
    };
  },
  methods: {
    ...mapActions(["listEvent", "deleteEvent", "loadings"]),
    load() {
      this.listEvent({ keyword: this.keyword })
        .then((response) => {
          this.loadings(false);
          this.list = response.data || [];
        })
        .catch(() => {
          this.loadings(false);
          this.list = [];
        });
    },
    search() {
      clearTimeout(this.timer);
      this.timer = setTimeout(this.load, 500);
    },
    formatDate(value) {
      if (!value) return "";
      const [y, m, d] = String(value).slice(0, 10).split("-");
      return d && m && y ? `${d}/${m}/${y}` : value;
    },
    confirmDestroy(id) {
      this.id_item = id;
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Bạn có chắc chắn",
        text: "Xóa sự kiện này",
        accept: this.destroy,
      });
    },
    destroy() {
      this.deleteEvent({ id: this.id_item }).then(() => {
        this.load();
        this.$success("Xóa thành công");
      });
    },
  },
  mounted() {
    this.load();
  },
};
</script>
