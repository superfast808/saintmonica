FROM node:22-bookworm-slim AS deps
WORKDIR /app
COPY package*.json ./
RUN npm install --omit=dev --no-audit --no-fund

FROM node:22-bookworm-slim
ENV NODE_ENV=production NPM_CONFIG_UPDATE_NOTIFIER=false
WORKDIR /app
RUN groupadd -r saintmonica && useradd -r -g saintmonica -d /app saintmonica
COPY --from=deps /app/node_modules ./node_modules
COPY server.js ./
COPY src ./src
COPY views ./views
COPY public ./public
COPY package.json ./
RUN mkdir -p /app/data && chown -R saintmonica:saintmonica /app/data
USER saintmonica
EXPOSE 8080
CMD ["node","server.js"]
