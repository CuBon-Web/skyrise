<template>
  <div>
    <div class="row">
      <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ objData.id ? 'Sửa sự kiện' : 'Thêm sự kiện' }}</h4>
            <div class="form-group">
              <label>Tiêu đề <span class="text-danger">*</span></label>
              <vs-input
                type="text"
                size="default"
                placeholder="VD: Ngày hội Khinh khí cầu Tp. Thủ Đức"
                class="w-100"
                v-model="objData.title"
              />
            </div>
            <div class="row">
              <div class="col-md-6 form-group">
                <label>Ngày diễn ra</label>
                <vs-input type="date" size="default" class="w-100" v-model="objData.event_date" />
              </div>
              <div class="col-md-6 form-group">
                <label>Thời gian</label>
                <vs-input
                  type="text"
                  size="default"
                  placeholder="VD: 05:30 – 09:30"
                  class="w-100"
                  v-model="objData.event_time"
                />
              </div>
            </div>
            <div class="form-group">
              <label>Địa điểm</label>
              <vs-input
                type="text"
                size="default"
                placeholder="VD: Tp. Thủ Đức, TP.HCM"
                class="w-100"
                v-model="objData.location"
              />
            </div>
            <div class="form-group">
              <label>Nội dung bài viết</label>
              <TinyMce v-model="objData.content" />
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="form-group">
              <label>Trạng thái</label>
              <vs-select v-model="objData.status" class="w-100">
                <vs-select-item :value="1" text="Hiện" />
                <vs-select-item :value="0" text="Ẩn" />
              </vs-select>
            </div>
            <div class="form-group">
              <label>Nhãn (hiển thị trên ảnh)</label>
              <vs-input
                type="text"
                size="default"
                placeholder="VD: Lễ hội, Du lịch, Festival"
                class="w-100"
                v-model="objData.tag"
              />
            </div>
            <div class="form-group">
              <label>Ảnh đại diện</label>
              <image-upload v-model="objData.image" :title="'su-kien-'" type="avatar"></image-upload>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row fixxed">
      <div class="col-12">
        <div class="saveButton">
          <vs-button color="primary" @click="submit">Lưu</vs-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import TinyMce from "../_common/tinymce";

const emptyEvent = () => ({
  id: null,
  title: "",
  image: "",
  event_date: "",
  event_time: "",
  location: "",
  tag: "",
  content: "",
  status: 1,
});

export default {
  name: "EventForm",
  props: {
    eventId: { type: [String, Number], default: null },
  },
  components: { TinyMce },
  data() {
    return {
      objData: emptyEvent(),
    };
  },
  methods: {
    ...mapActions(["saveEvent", "detailEvent", "loadings"]),
    load() {
      if (!this.eventId) return;
      this.loadings(true);
      this.detailEvent({ id: this.eventId })
        .then((response) => {
          this.loadings(false);
          if (!response.data) {
            this.$error("Không tìm thấy sự kiện");
            this.$router.push({ name: "listEvent" });
            return;
          }
          this.objData = Object.assign(emptyEvent(), response.data, {
            status: Number(response.data.status),
            event_date: response.data.event_date || "",
          });
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Không tải được sự kiện");
        });
    },
    submit() {
      if (!String(this.objData.title || "").trim()) {
        this.$error("Tiêu đề không được để trống");
        return;
      }
      this.loadings(true);
      this.saveEvent(this.objData)
        .then(() => {
          this.loadings(false);
          this.$success(this.objData.id ? "Cập nhật sự kiện thành công" : "Thêm sự kiện thành công");
          this.$router.push({ name: "listEvent" });
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Lưu sự kiện thất bại");
        });
    },
  },
  mounted() {
    this.load();
  },
};
</script>
