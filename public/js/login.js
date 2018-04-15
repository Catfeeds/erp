! function () {
  $(document)
    .ready(function () {
      $('.ui.form')
        .form({
          fields: {
            phone: {
              identifier: 'phone',
              rules: [{
                  type: 'empty',
                  prompt: '请输入你的手机号'
                },
                {
                  type: 'regExp[/^1(\\d{10})$/]',
                  prompt: '请输入正确的手机号！'
                }
              ]
            },
            password: {
              identifier: 'password',
              rules: [{
                  type: 'empty',
                  prompt: '请输入你的密码'
                },
                {
                  type: 'length[6]',
                  prompt: '密码至少 6 位'
                }
              ]
            }
          }
        })

      const $phoneValidate = $('#phoneValidate')
      const $smsBtn = $('#smsBtn')
      let smsFlag = false

      //手机号检验
      $phoneValidate.on('blur', function (e) {
        if (smsFlag) {
          return false
        }
        if ($('.ui.form').form('is valid', 'phone')) {
          $smsBtn.removeClass('disabled')
        }
      })
      let smsTimer

      //发送验证码
      $smsBtn.on('click', function () {
        smsFlag = true
        const self = $(this)
        self.addClass('disabled loading')
        let seconds = 60
        smsTimer = setInterval(() => {
          self.removeClass('loading')
          seconds--
          if (seconds > 0) {
            let innerHtml = `${seconds}秒后重新发送`
            self.text(innerHtml)
          } else {
            smsFlag = false
            self.removeClass('disabled')
            self.text('获取验证码')
            clearInterval(smsTimer)
          }
        }, 1000) 
      })
    })
}()
