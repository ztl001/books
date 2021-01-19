### neovim使用

#### 下载neovim

```shell
wget  https://github.com/neovim/neovim/releases/download/v0.4.4/nvim-linux64.tar.gz
```

#### 解压到/use/local

```shell
tar -zxvf nvim-linux64.tar.gz
cp -r nvim-linux64 /usr/local/nvim
```

#### 配置环境变量

```shell
export PATH=$PATH:/usr/local/nvim/bin/
source /etc/profile
```

#### 下载vim-plug插件管理器

```shell
git clone https://gitee.com/jguow/vim-plug.git
```

#### 复制vim-plug/vim/plug.vim 到 ~/.config/nvim/autoload/目录下

```shell
cp plug.vim  ../.config/nvim/autoload/
```

#### 配色安装 molokai

```shell
cd /home/vagrant/.config/nvim/colors
git clone https://github.com/tomasr/molokai.git 
cp molokai/colors/molokai.vim .
```

#### 修改init.vim

```shell
set nu
set ignorecase
set encoding=UTF-8
colorscheme molokai
let g:molokai_original = 1
let g:rehash256 = 1
```



