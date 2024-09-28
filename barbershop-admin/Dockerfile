FROM node:20

WORKDIR /var/www/barbershop-admin

COPY package*.json ./

RUN npm install

COPY . .   

CMD ["npm", "run", "dev", "--", "--host=0.0.0.0", "--port=8001"]