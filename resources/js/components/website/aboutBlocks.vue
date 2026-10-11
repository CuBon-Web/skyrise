<template>
  <div>
    <h3 class="page-title">Quản lý "Tầm nhìn - Sứ mệnh - Giá trị cốt lõi"</h3>
    <p class="text-muted">Các khối hiển thị trên trang Giới thiệu theo thứ tự bên dưới. Để trống ảnh nền sẽ dùng nền trời mặc định.</p>
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div v-for="(block, key) in objData" :key="'block-' + key" class="about-block-admin">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <strong>Khối #{{ key + 1 }}{{ block.title ? ': ' + block.title : '' }}</strong>
                <div class="about-block-admin__tools">
                  <vs-button size="small" type="border" icon="arrow_upward" :disabled="key === 0" @click="moveBlock(key, -1)"></vs-button>
                  <vs-button size="small" type="border" icon="arrow_downward" :disabled="key === objData.length - 1" @click="moveBlock(key, 1)"></vs-button>
                  <vs-button size="small" color="danger" type="border" icon="delete" @click="removeBlock(key)"></vs-button>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Ảnh nền (khuyên dùng 1600x700)</label>
                    <image-upload type="avatar" v-model="block.image" :title="'about-block-' + (key + 1)"></image-upload>
                  </div>
                  <div class="form-group">
                    <label>Khinh khí cầu trang trí</label>
                    <vs-select v-model="block.decor">
                      <vs-select-item value="1" text="Hiện" />
                      <vs-select-item value="0" text="Ẩn" />
                    </vs-select>
                  </div>
                  <div class="form-group">
                    <label>Trạng thái</label>
                    <vs-select v-model="block.status">
                      <vs-select-item value="1" text="Hiện" />
                      <vs-select-item value="0" text="Ẩn" />
                    </vs-select>
                  </div>
                </div>

                <div class="col-md-9">
                  <div class="form-group">
                    <label>Tiêu đề <span class="text-danger">*</span></label>
                    <vs-input v-model="block.title" placeholder="VD: Tầm Nhìn" class="w-100" />
                  </div>
                  <div class="form-group">
                    <label>Đoạn giới thiệu</label>
                    <textarea v-model="block.intro" rows="3" class="form-control" placeholder="Đoạn mô tả ngắn dưới tiêu đề (có thể để trống)"></textarea>
                  </div>

                  <label class="mb-2">Các ý chính</label>
                  <div v-for="(item, i) in block.items" :key="'item-' + key + '-' + i" class="about-block-admin__item">
                    <span class="about-block-admin__index">{{ i + 1 }}</span>
                    <div class="about-block-admin__fields">
                      <vs-input v-model="item.title" placeholder="Tiêu đề ý (VD: Thương hiệu được tin chọn)" class="w-100 mb-2" />
                      <textarea v-model="item.description" rows="2" class="form-control" placeholder="Mô tả ngắn"></textarea>
                    </div>
                    <div class="about-block-admin__item-tools">
                      <vs-button size="small" type="flat" icon="arrow_upward" :disabled="i === 0" @click="moveItem(block, i, -1)"></vs-button>
                      <vs-button size="small" type="flat" icon="arrow_downward" :disabled="i === block.items.length - 1" @click="moveItem(block, i, 1)"></vs-button>
                      <vs-button size="small" type="flat" color="danger" icon="clear" @click="block.items.splice(i, 1)"></vs-button>
                    </div>
                  </div>
                  <vs-button size="small" type="border" icon="add" @click="block.items.push(defaultItem())">Thêm ý</vs-button>
                </div>
              </div>

              <hr />
            </div>

            <vs-button color="primary" @click="saveBlocks">Lưu</vs-button>
            <vs-button color="success" @click="objData.push(defaultBlock())">Thêm khối</vs-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions } from "vuex";

const defaultItem = () => ({ title: "", description: "" });
const defaultBlock = () => ({
  title: "",
  intro: "",
  image: "",
  decor: "1",
  status: "1",
  items: [defaultItem()],
});

export default {
  name: "aboutBlocks",
  data() {
    return {
      objData: [],
    };
  },
  methods: {
    ...mapActions(["saveAboutBlocks", "listAboutBlocks", "loadings"]),
    defaultItem,
    defaultBlock,

    moveBlock(index, step) {
      const target = index + step;
      if (target < 0 || target >= this.objData.length) return;
      const moved = this.objData.splice(index, 1)[0];
      this.objData.splice(target, 0, moved);
    },

    moveItem(block, index, step) {
      const target = index + step;
      if (target < 0 || target >= block.items.length) return;
      const moved = block.items.splice(index, 1)[0];
      block.items.splice(target, 0, moved);
    },

    removeBlock(index) {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Xóa khối",
        text: "Khối sẽ bị xóa sau khi bấm Lưu. Tiếp tục?",
        accept: () => this.objData.splice(index, 1),
      });
    },

    saveBlocks() {
      const invalid = this.objData.findIndex((block) => !String(block.title || "").trim());
      if (invalid !== -1) {
        this.$error(`Khối #${invalid + 1}: Tiêu đề không được để trống.`);
        return;
      }
      this.loadings(true);
      this.saveAboutBlocks({ data: this.objData })
        .then(() => {
          this.loadings(false);
          this.$success("Lưu thành công");
          this.loadBlocks();
        })
        .catch(() => {
          this.loadings(false);
          this.$error("Lưu thất bại");
        });
    },

    loadBlocks() {
      this.loadings(true);
      this.listAboutBlocks()
        .then((response) => {
          this.loadings(false);
          const rows = response.data || [];
          this.objData = rows.length
            ? rows.map((row) => ({
                ...defaultBlock(),
                ...row,
                intro: row.intro || "",
                image: row.image || "",
                decor: String(row.decor ?? 1),
                status: String(row.status ?? 1),
                items: Array.isArray(row.items) && row.items.length
                  ? row.items.map((item) => ({ ...defaultItem(), ...item }))
                  : [defaultItem()],
              }))
            : [defaultBlock()];
        })
        .catch(() => {
          this.loadings(false);
        });
    },
  },
  mounted() {
    this.loadBlocks();
  },
};
</script>

<style scoped>
.about-block-admin__tools .vs-button,
.about-block-admin__item-tools .vs-button {
  margin-left: 4px;
}

.about-block-admin__item {
  display: flex;
  align-items: flex-start;
  gap: 10px;
  margin-bottom: 12px;
  padding: 12px;
  border: 1px solid #e5e9f2;
  border-radius: 8px;
  background: #fafbfd;
}

.about-block-admin__index {
  display: inline-flex;
  flex: 0 0 auto;
  align-items: center;
  justify-content: center;
  width: 26px;
  height: 26px;
  border-radius: 50%;
  background: #f9842b;
  color: #fff;
  font-size: 12px;
  font-weight: 700;
}

.about-block-admin__fields {
  flex: 1 1 auto;
  min-width: 0;
}

.about-block-admin__item-tools {
  display: flex;
  flex-direction: column;
}

hr {
  margin: 24px 0;
  border: 0;
  border-top: 1px solid #04040426;
}
</style>
