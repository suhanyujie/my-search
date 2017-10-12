<template>
    <div class="row">
        <el-row type="flex">
            <el-col :span="6">
                <div>
                    <h2>标题</h2>
                    <div class="article-brief">
                        <p>
                            但是，虽然$A可以像数组那样操作，却无法使用foreach遍历，除非部署了前面提到的Iterator界面。
                            另一个解决方法是，有时会需要将数据和遍历部分分开，这时就可以部署IteratorAggregate界面。它规定了一个getIterator()方法，返回一个使用Iterator界面的object。
                        </p>
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
                _this.$http.post('/article/store', param).then(reponse => {

                });
            },
            // 搜索
            handleIconClick(ev) {
                var _this = this;
                var keyword = _this.searchForm.searchKeyword;
                var param = {
                    params: {
                        keyword: keyword
                    }
                };
                _this.$http.get('/search/' + keyword, param).then(response => {
                    if (response.error_no != 0) {

                    }
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