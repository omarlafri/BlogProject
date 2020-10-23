<template>
  <div class="content">
    <div class="container-fluid">
      <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
      <div
        class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
      >
        <p class="_title0">
          Categories
          <Button @click="addModal = true"
            ><Icon type="md-add" /> Add category</Button
          >
        </p>

        <div class="_overflow _table_div">
          <table class="_table">
            <!-- TABLE TITLE -->
            <tr>
              <th>ID</th>
              <th>Category name</th>
              <th>Category icone</th>

              <th>Created at</th>
              <th>Action</th>
            </tr>
            <!-- TABLE TITLE -->

            <!-- ITEMS -->
            <tr
              v-for="(category, i) in categories"
              :key="i"
              :v-if="categories.length"
            >
              <td>{{ category.id }}</td>
              <td>
                <strong> {{ category.categoryName }}</strong>
              </td>
              <td>
                <img
                  :src="`/uploads/${category.iconeImage}`"
                  style="width: 50px; height: 50px"
                />
              </td>

              <td>{{ category.created_at }}</td>
              <td>
                <Button type="info" @click="showNameEditModal(category, i)"
                  >Edit name</Button
                >
                <Button type="success" @click="showImgEditModal(category, i)"
                  >Edit image</Button
                >
                <Button type="error" @click="showDeleteModal(category, i)"
                  >Delete</Button
                >
              </td>
            </tr>
          </table>

          <!-- add Category Modal -->
          <Modal
            v-model="addModal"
            title="Add category"
            :mask-closable="false"
            :closable="false"
          >
            <Input
              v-model="data.categoryName"
              placeholder="Enter the tag name"
              style="width: 100%"
            />
            <br />
            <div class="space"></div>

            <Upload
              type="drag"
              ref="uploads"
              action="/app/upload"
              :on-success="handleSuccess"
              :format="['jpg', 'jpeg', 'png']"
              multiple
              :max-size="2048"
              :on-remove="removeFile"
              :before-upload="handleBeforeUpload"
              :on-format-error="handleFormatError"
              :headers="{
                'x-csrf-token': token,
                'X-Requested-With': 'XMLHttpRequest',
              }"
              style="margin-top: 10px"
            >
              <div style="padding: 20px 0">
                <Icon
                  type="ios-cloud-upload"
                  size="52"
                  style="color: #3399ff"
                ></Icon>
                <p>Click or drag files here to upload</p>
              </div>
            </Upload>
            <div class="demo-upload-list" v-if="data.img">
              <img :src="`/uploads/${data.img}`" />
            </div>

            <div slot="footer">
              <Button
                type="default"
                @click="closeModal"
                :disabled="isClosing"
                :loading="isClosing"
                >{{ isClosing ? "Closing ..." : " Close" }}
              </Button>
              <Button
                type="primary"
                @click="addCategory"
                :disabled="isAding"
                :loading="isAding"
                >{{ isAding ? "Adding ..." : " Add category" }}
              </Button>
            </div>
          </Modal>

          <!-- edit name Modal -->

          <Modal
            v-model="editNameModal"
            title="Edit category name"
            :mask-closable="false"
            :closable="false"
          >
            <Input v-model="editData.categoryName" style="width: 300px" />
            <br />
            <div class="space"></div>
            <div slot="footer">
              <Button type="default" @click="editNameModal = false" :disabled="isEditing">Close </Button>
              <Button
                type="primary"
                @click="editCat()"
                :disabled="isEditing"
                :loading="isEditing"
                >{{ isEditing ? "Editing ..." : " Edit category" }}
              </Button>
            </div>
          </Modal>

          <!-- edit image Modal -->

          <Modal
            v-model="editImgModal"
            title="Edit category image"
            :mask-closable="false"
            :closable="false"
          >
          
            <br />
            <div class="space"></div>

            <Upload
              type="drag"
              ref="EditUploads"
              action="/app/upload"
              :on-success="editHandleSuccess"
              :format="['jpg', 'jpeg', 'png']"
              multiple
              :max-size="2048"
              :on-format-error="handleFormatError"
              :headers="{
                'x-csrf-token': token,
                'X-Requested-With': 'XMLHttpRequest',
              }"
              style="margin-top: 10px"
            >
              <div style="padding: 20px 0">
                <Icon
                  type="ios-cloud-upload"
                  size="52"
                  style="color: #3399ff"
                ></Icon>
                <p>Click or drag your image here to upload</p>
              </div>
            </Upload>
           
            <div slot="footer">
              <Button type="default" @click="editImgModal = false" :disabled="isEditing"
                :loading="isEditing"
                >{{ isEditing ? "Editing ..." : " Close" }} </Button>
            </div>
          </Modal>

          <!-- Delete category Modal -->

          <Modal v-model="deleteModal" width="360">
            <p slot="header" style="color: #f60; text-align: center">
              <Icon type="ios-information-circle"></Icon>
              <span>Delete confirmation</span>
            </p>
            <div style="text-align: center">
              <p>Do u wanna delete the category called {{ deleteData.categoryName }}</p>
            </div>
            <div slot="footer">
              <Button
                type="error"
                size="large"
                long
                :disabled="isDeleting"
                :loading="isDeleting"
                @click="deleteCat"
                >Delete</Button
              >
            </div>
          </Modal>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        categoryName: "",
        img: "",
      },
      addModal: false,
	  editNameModal: false,
      editImgModal: false,
	  
      isAding: false,
      isEditing: false,
      isDeleting: false,
      isClosing: false,

      editData: {
        categoryName: "",
        iconeImage: "",
      },
      token: "",

      index: -1,

      categories: [],
      deleteData: {
        id: "",
        categoryName:"",
        
      },
      deleteModal: false,
    };
  },

  methods: {
    async addCategory() {
      this.isAding = true;
      if (this.data.categoryName.trim() == "") {
        this.isAding = false;

        return this.error("Oops", "Category name is required");
      }
      if (this.data.img.trim() == "") {
        this.isAding = false;

        return this.error("Oops", "Category icone  is required");
      }
      const res = await this.callApi("post", "app/create_category", this.data);
      if (res.status == 201) {
        this.categories.unshift(res.data);
        this.success("Done", "Category added succefuly");
        this.addModal = false;
        this.data.categoryName = "";
        this.data.img = "";
      }
      this.addModal = false;
      this.isAding = false;
    },


    async editCat() {
      this.isEditing = true;
      this.editData.iconeImage="0";
      if (this.editData.categoryName.trim() == "") {
      this.isEditing = false;
        return this.error("Oops", "Tag name is required");

      }  
      const resEdit = await this.callApi("post", "app/edit_cat", this.editData);
      if (resEdit.status == 200) {
        this.success("Great", "Name category was edited succefuly");
        this.categories[this.index].categoryName = this.editData.categoryName;
	
	  }
	  else{
		this.error(
        file.name + "  Error ",
        "Category not uploded succefuly"
      );
      
    }
        await this.$refs.EditUploads.clearFiles();
    	this.editData.iconeImage = "";
      this.editData.categoryName = "";
		  this.editData.id = 0;
	   	this.index=-1;
      this.editNameModal = false;
      this.editImgModal = false;
      this.isEditing = false;
    },

    async deleteCat() {
      this.isDeleting = true;

      const res = await this.callApi("post", "app/delete_cat", this.deleteData);
      if (res.status == 200) {
        this.success("", "Category deleted succefuly");
        this.categories.splice(this.deleteData.index, 1);
       
        this.deleteData.id = 0;
        this.deleteData.categoryName = '';
        this.deleteData.index = -1;
      }
      this.deleteModal = false;
      this.isDeleting = false;
    },

    showImgEditModal(category, i) {
      let obj = {
        id: category.id,
        categoryName: category.categoryName,
        iconeImage: category.iconeImage,
      };
      this.editData = obj;
      this.index = i;
      this.editImgModal = true;
    },

    showNameEditModal(category, i) {
      let obj = {
        id: category.id,
        categoryName: category.categoryName,
        iconeImage: category.iconeImage,
      };
      this.editData = obj;
      this.index = i;
      this.editNameModal = true;
    },
    showDeleteModal(category, i) {
      this.deleteModal = true;
      this.$set(category, "isDeleting", true);
       let obj = {
        id: category.id,
        categoryName: category.categoryName,
       
      };
      this.deleteData = obj;
    },

    async handleSuccess(res, file) {
      this.data.img = res;
      this.success("Greate", "The image is loaded   " + file.name);
	},
	
	async editHandleSuccess(res, file) {
      this.isEditing = true;
      this.editData.iconeImage = res;
	  this.success("Greate", "The image is  updated   " + file.name);
	  const resEdit = await this.callApi("post", "app/edit_cat", this.editData);
      if (resEdit.status == 200) {
        this.success("Great", "Image category was edited succefuly");
        this.categories[this.index].iconeImage = this.editData.iconeImage;
	
	  }
	  else{
		this.error(
        file.name + "  Error ",
        "Category not uploded succefuly"
      );
      
    }
        await this.$refs.EditUploads.clearFiles();
    	this.editData.iconeImage = "";
      this.editData.categoryName = "";
		  this.editData.id = 0;
	   	this.index=-1;
      this.editNameModal = false;
      this.editImgModal = false;
      this.isEditing = false;
      
	},

    handleFormatError(file) {
      this.error(
        file.name + "  format is incorrect",
        "please select jpg or png."
      );
    },


    handleMaxSize(file) {
      this.$Notice.warning({
        title: "Exceeding file size limit",
        desc: "File  " + file.name + " is too large, no more than 2M.",
      });
    },
    
    async handleBeforeUpload() {
      if (this.data.img) {
        const res = await this.callApi("post", "app/remove_file", {
          img: this.data.img,
        });
        this.data.img = "";
        await this.$refs.uploads.clearFiles();
      }

      return true;
    },

    async removeFile() {
      const res = await this.callApi("post", "app/remove_file", {
        img: this.data.img,
      });
      this.$refs.uploads.clearFiles();
      this.data.img = "";
    },
    async closeModal() {
      this.isClosing = true;
      if (this.data.img) {
        const res = await this.callApi("post", "app/remove_file", {
          img: this.data.img,
        });
        this.data.img = "";
        await this.$refs.uploads.clearFiles();
      }
      this.addModal = false;
      this.isClosing = false;
    },
  },

  async created() {
    this.token = window.Laravel.csrfToken;
    const res = await this.callApi("get", "app/get_categories");
    if (res.status == 200) {
      this.categories = res.data;
    }
  },
};
</script>