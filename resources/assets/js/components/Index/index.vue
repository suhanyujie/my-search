<template>
    <div class="row">
        <el-row type="flex">
            <el-col :span="6">
                <div class="article-result" v-for="item in searchResult">
                    <h2>{{ item._source.title }}</h2>
                    <div class="article-brief">
                        {{ item._source.content }}
                    </div>
                </div>
            </el-col>
            <el-col :span="18">
                <el-col :span="24">
                    <el-form :model="searchForm" :rules="rules2" ref="searchForm" label-width="60px"
                             class="demo-ruleForm">
                        <el-form-item label="" prop="keywordProp">
                            <el-input
                                    placeholder="请输入搜索内容"
                                    icon="search"
                                    v-model="searchForm.searchKeyword"
                                    :on-icon-click="handleIconClick">
                            </el-input>
                        </el-form-item>
                    </el-form>
                </el-col>
                <el-col :span="24" style="margin-top:200px;">
                    <el-form :model="addNoteForm" :rules="addNoteRules" ref="addNoteForm" label-width="60px">
                        <el-form-item label="标题" prop="titleProp">
                            <el-input type="text" v-model="addNoteForm.title" auto-complete="off"></el-input>
                        </el-form-item>
                        <el-form-item label="描述" prop="descProp">
                            <el-input
                                    type="textarea"
                                    :rows="2"
                                    placeholder="请输入内容"
                                    v-model="addNoteForm.content">
                            </el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button @click="saveContent">保存</el-button>
                            <el-button>重置</el-button>
                        </el-form-item>

                    </el-form>
                </el-col>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        data() {
            var validateContent = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入内容'));
                } else {
                    if (this.searchForm.validateContent !== '') {
                        this.$refs.searchForm.validateField('validateContent');
                    }
                    callback();
                }
            };
            return {
                apiUrl: '/search/index',
                apiBaseUrl: '',
                searchResult: [],
                searchForm: {
                    validateContent: '',
                    searchKeyword: ''
                },
                addNoteForm: {
                    title: '',
                    content: ''
                },
                rules2: {
                    validateContent: [
                        {validator: validateContent, trigger: 'blur'}
                    ]
                },
                addNoteRules: {}
            };
        },
        methods: {
            // 文章内容的保存
            saveContent: function () {
                var _this = this;
                var param = {
                    title: _this.addNoteForm.title,
                    content: _this.addNoteForm.content
                };
                _this.$http.post('/article/store', param).then(response => {
                    var responseData = response.data;
                    this.$message(responseData.message);
                    if(responseData.status != 1) {
                        return;
                    }
                    console.log(response);
                });
            },
            // 搜索
            handleIconClick(ev) {
                var _this = this;
                var keyword = _this.searchForm.searchKeyword;
                var optionsObject = {
                    params: {
                        keyword: keyword
                    }
                };
                _this.$http.get('/api/search', optionsObject).then(response => {
                    if (response.data.status != 1) {
                        this.$message('请求异常！请稍候再试');
                    }
                    _this.searchResult = response.data.data.hits.hits;
                    console.log(response);
                });
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        alert('submit!');
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            }
        }
    }

</script>