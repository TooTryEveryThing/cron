#  快速将图片的名字加入到图片中
# caatgpt的回答 https://chat.openai.com/share/026a2853-8540-4d4e-9b8d-0b50fde5eaac
# pip install pillow
from PIL import Image, ImageDraw, ImageFont
import os

# 输入图片文件夹路径和输出文件夹路径
input_folder = "D:\study\TooTryEveryThing\cron\image"
output_folder = "D:\study\TooTryEveryThing\c"

# 获取图片文件列表
image_files = os.listdir(input_folder)

# 设置文本颜色和字体大小
text_color = (255, 255, 255)  # 白色
font_size = 20
font = ImageFont.truetype("arial.ttf", font_size)


for image_file in image_files:
    if image_file.lower().endswith(('.png', '.jpg', '.jpeg', '.gif', '.bmp')):
        # 打开图片
        img = Image.open(os.path.join(input_folder, image_file))
        
        # 在图片上创建Draw对象
        draw = ImageDraw.Draw(img)
        
        # 获取图片的宽度和高度
        width, height = img.size
        
        # 图片的名称（去除文件扩展名）
        image_name = os.path.splitext(image_file)[0]
        
        # 计算文本位置（位于图片左上角）
        text_position = (10, 10)
        
        # 将图片名称添加到图片中
        draw.text(text_position, image_name, fill=text_color, font=font)
        
        # 保存修改后的图片
        output_path = os.path.join(output_folder, image_file)
        img.save(output_path)
        print(f"已处理：{image_file}")

print("操作完成！")
