(function($, document, window){
    var path = $('#keni_input_template_directory').val();

    tinymce.create(
        'tinymce.plugins.KeniButtons',
        {
            init: function(ed, url)
            {
              // アイコン
              var arr_icon_list = {
                point: 'ポイント',
                caution: '注意',
                blank: '別ウインドウ',
                arrow_up: '矢印上',
                arrow_right: '矢印右',
                arrow_down: '矢印下',
                arrow_left: '矢印左',
                download: 'ダウンロード',
                pdf: 'PDF',
                zip: 'ZIP',
                mail: 'メール',
                cart: 'ショッピングカート',
                search: '虫眼鏡',
                home: 'ホーム',
                folder: 'フォルダ',
                time: '時計',
                calendar: 'カレンダー',
                building: 'ビル',
                map: 'マップ',
                new: 'NEW',
                beginner: '初心者マーク',
              };

              var icon_menu_list = [];
              jQuery.each(arr_icon_list, function(key, val) {
                icon_menu_list.push({
                        text: val,
                        icon: 'ico icon_'+key,
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('icon_'+key, false);
                        }
                      });
              });
              ed.addButton(
                  'icon',
                  {
                    type: 'menubutton',
                    text: 'アイコン',
                    menu: icon_menu_list
                  }
              );

              jQuery.each(arr_icon_list, function(key, val) {
                ed.addCommand('icon_'+key, function(){
                      var selected_text = ed.selection.getContent(),
                          return_text = '<i class="icon_'+key+'"></i>';
                     tinyMCE.activeEditor.selection.setContent(return_text);
                });
              });

              // マーカー
              var arr_line_list = {
                yellow:'黄',
                orange:'橙',
                pink:'ピンク',
                blue:'青',
                lime:'ライム',
                gray:'灰',
              };

              var line_menu_list = [];
              jQuery.each(arr_line_list, function(key, val) {
                line_menu_list.push({
                        text: val,
                        class: 'test',
                        icon: 'forecolor line-'+key,
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('line_'+key, false);
                        }
                      });
              });
              ed.addButton(
                  'line',
                  {
                    type: 'menubutton',
                    text: 'マーカー',
                    menu: line_menu_list
                  }
              );

              jQuery.each(arr_line_list, function(key, val) {
                ed.addCommand('line_'+key, function(){
                      var selected_text = ed.selection.getContent(),
                          return_text = '<span class="line-'+key+'">' + selected_text + '</span>';
                      ed.execCommand( 'mceInsertContent', 0, return_text );
                });
              });

              // 文字サイズ
              var arr_size_list = {
                f10rem: '10rem',
                f12rem: '12rem',
                f14rem: '14rem',
                f16rem: '16rem',
                f18rem: '18rem',
                f20rem: '20rem',
                f22rem: '22rem',
                f24rem: '24rem',
              };

              var text_size_menu_list = [];
              jQuery.each(arr_size_list, function(key, val) {
                text_size_menu_list.push({
                        text: val,
                        icon: 'forecolor keni-font-size '+key,
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('text_size_'+key, false);
                        }
                      });
              });
              ed.addButton(
                  'text_size',
                  {
                    type: 'menubutton',
                    text: '文字サイズ',
                    menu: text_size_menu_list
                  }
              );

              jQuery.each(arr_size_list, function(key, val) {
                ed.addCommand('text_size_'+key, function(){
                      var selected_text = ed.selection.getContent(),
                          return_text = '<span class="'+key+'">' +selected_text + '</span>';
                      ed.execCommand( 'mceInsertContent', 0, return_text );
                });
              });

              // 文字色
              var arr_color_list = {
                red:'赤',
                blue:'青',
                green:'緑',
                yellow:'黄',
                navy:'紺',
                orange:'橙',
                pink:'ピンク',
                purple:'紫',
                olive:'オリーブ',
                lime:'黄緑',
                aqua:'水色',
                black:'黒',
                gray:'灰',
                white:'白',
                brown:'茶',
              };

              var text_color_menu_list = [];
              jQuery.each(arr_color_list, function(key, val) {
                text_color_menu_list.push({
                        text: val,
                        icon: 'forecolor '+key,
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('text_color_'+key, false);
                        }
                      });
              });
              ed.addButton(
                  'text_color',
                  {
                    type: 'menubutton',
                    text: '文字色',
                    menu: text_color_menu_list
                  }
              );

              jQuery.each(arr_color_list, function(key, val) {
                ed.addCommand('text_color_'+key, function(){
                      var selected_text = ed.selection.getContent(),
                          return_text = '<span class="'+key+'">' + selected_text + '</span>';
                      ed.execCommand( 'mceInsertContent', 0, return_text );
                });
              });

              // 注意書き
              ed.addButton(
                  'note',
                  {
                      title: 'note',
                      text: '※注意書き',
                      cmd: 'note_cmd'
                  }
              );
              ed.addCommand( 'note_cmd', function()
              {
                var selected_text = ed.selection.getContent(),
                    return_text = '<span class="note">※' + selected_text + '</span>';
                ed.execCommand( 'mceInsertContent', 0, return_text );
              });

              // 画像カラム（余白有り）
              ed.addButton(
                  'column',
                  {
                    type: 'menubutton',
                    text: 'カラム（余白有り）',
                    menu: [
                      {
                        text: 'カラム2',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_2', false);
                        }
                      },
                      {
                        text: 'カラム3',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_3', false);
                        }
                      },
                      {
                        text: 'カラム4',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_4', false);
                        }
                      },
                      {
                        text: 'カラム5',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_5', false);
                        }
                      },
                      {
                        text: 'カラム6',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_6', false);
                        }
                      },
                      ]
                  }
              );

              ed.addCommand('column_2', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col2-wrap">';
                      for (var i_child = 0; i_child < 2; i_child++) {
                        return_text += '<div class="col">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('column_3', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col3-wrap">';
                      for (var i_child = 0; i_child < 3; i_child++) {
                        return_text += '<div class="col">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('column_4', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col4-wrap">';
                      for (var i_child = 0; i_child < 4; i_child++) {
                        return_text += '<div class="col">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('column_5', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col5-wrap">';
                      for (var i_child = 0; i_child < 5; i_child++) {
                        return_text += '<div class="col">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('column_6', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col6-wrap">';
                      for (var i_child = 0; i_child < 6; i_child++) {
                        return_text += '<div class="col">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });

              ed.addButton(
                  'column_ns',
                  {
                    type: 'menubutton',
                    text: 'カラム（余白無し）',
                    menu: [
                      {
                        text: 'カラム2',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_ns_2', false);
                        }
                      },
                      {
                        text: 'カラム3',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_ns_3', false);
                        }
                      },
                      {
                        text: 'カラム4',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_ns_4', false);
                        }
                      },
                      {
                        text: 'カラム5',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_ns_5', false);
                        }
                      },
                      {
                        text: 'カラム6',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('column_ns_6', false);
                        }
                      },
                      ]
                  }
              );

              ed.addCommand('column_ns_2', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col2-wrap">';
                      for (var i_child = 0; i_child < 2; i_child++) {
                        return_text += '<div class="col_ns">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('column_ns_3', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col3-wrap">';
                      for (var i_child = 0; i_child < 3; i_child++) {
                        return_text += '<div class="col_ns">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('column_ns_4', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col4-wrap">';
                      for (var i_child = 0; i_child < 4; i_child++) {
                        return_text += '<div class="col_ns">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('column_ns_5', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col5-wrap">';
                      for (var i_child = 0; i_child < 5; i_child++) {
                        return_text += '<div class="col_ns">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('column_ns_6', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="col6-wrap">';
                      for (var i_child = 0; i_child < 6; i_child++) {
                        return_text += '<div class="col_ns">■</div>';
                      }
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });


              // box
              ed.addButton(
                  'box_style',
                  {
                    type: 'menubutton',
                    text: 'ボックス',
                    menu: [
                      {
                        text: '青色',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('box_style_blue', false);
                        }
                      },
                      {
                        text: '緑色',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('box_style_green', false);
                        }
                      },
                      {
                        text: 'オレンジ',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('box_style_orange', false);
                        }
                      },
                      {
                        text: '赤色',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('box_style_red', false);
                        }
                      },
                      {
                        text: 'ピンク',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('box_style_pink', false);
                        }
                      },
                      {
                        text: '黄色',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('box_style_yellow', false);
                        }
                      },
                      {
                        text: 'グレー',
                        onselect:function(){
                         tinyMCE.activeEditor.execCommand('box_style_gray', false);
                        }
                      },
                      ]
                  }
              );

              ed.addCommand('box_style_blue', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="box_style box_style_blue">';
                      return_text += '<div class="box_inner">';
                      return_text += '<div class="box_style_title"><span class="box_style_title_inner">タイトルが入ります。</span></div>';
                      return_text += '<p>テキストが入ります。</p>';
                      return_text += 'ここにコンテンツを記載';
                      return_text += '</div>';
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('box_style_green', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="box_style box_style_green">';
                      return_text += '<div class="box_inner">';
                      return_text += '<div class="box_style_title"><span class="box_style_title_inner">タイトルが入ります。</span></div>';
                      return_text += '<p>テキストが入ります。</p>';
                      return_text += 'ここにコンテンツを記載';
                      return_text += '</div>';
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('box_style_orange', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="box_style box_style_orange">';
                      return_text += '<div class="box_inner">';
                      return_text += '<div class="box_style_title"><span class="box_style_title_inner">タイトルが入ります。</span></div>';
                      return_text += '<p>テキストが入ります。</p>';
                      return_text += 'ここにコンテンツを記載';
                      return_text += '</div>';
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('box_style_red', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="box_style box_style_red">';
                      return_text += '<div class="box_inner">';
                      return_text += '<div class="box_style_title"><span class="box_style_title_inner">タイトルが入ります。</span></div>';
                      return_text += '<p>テキストが入ります。</p>';
                      return_text += 'ここにコンテンツを記載';
                      return_text += '</div>';
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('box_style_pink', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="box_style box_style_pink">';
                      return_text += '<div class="box_inner">';
                      return_text += '<div class="box_style_title"><span class="box_style_title_inner">タイトルが入ります。</span></div>';
                      return_text += '<p>テキストが入ります。</p>';
                      return_text += 'ここにコンテンツを記載';
                      return_text += '</div>';
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('box_style_yellow', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="box_style box_style_yellow">';
                      return_text += '<div class="box_inner">';
                      return_text += '<div class="box_style_title"><span class="box_style_title_inner">タイトルが入ります。</span></div>';
                      return_text += '<p>テキストが入ります。</p>';
                      return_text += 'ここにコンテンツを記載';
                      return_text += '</div>';
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });
              ed.addCommand('box_style_gray', function(){
                var selected_text = ed.selection.getContent(),
                      return_text = '<div class="box_style box_style_gray">';
                      return_text += '<div class="box_inner">';
                      return_text += '<div class="box_style_title"><span class="box_style_title_inner">タイトルが入ります。</span></div>';
                      return_text += '<p>テキストが入ります。</p>';
                      return_text += 'ここにコンテンツを記載';
                      return_text += '</div>';
                      return_text += '</div>';

                      tinyMCE.activeEditor.selection.setContent(return_text);
              });

            },

            createControl: function(n,cm)
            {
                return null;
            }
        }
    );
    tinymce.PluginManager.add(
        'custom_button_script',
        tinymce.plugins.KeniButtons
    );


})(jQuery, document, window);


