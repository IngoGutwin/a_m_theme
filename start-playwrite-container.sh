#!/usr/bin/env bash

CONTAINER_NAME="am_playwright_runner"
IMAGE="mcr.microsoft.com/playwright:v1.58.2-jammy"

check_if_container_exists () {
  echo "$(docker ps -a -q -f name=${CONTAINER_NAME})"
}

run_new_container () {
  echo "$(docker run -dit \
    --name ${CONTAINER_NAME} \
    --network host \
    --init \
    --ipc=host \
    -v "$(pwd)":/app \
    -w /app \
    -e PLAYWRIGHT_BROWSERS_PATH=/ms-playwright \
    ${IMAGE} \
    tail -f /dev/null)"
}

CONTAINER_ID=$(check_if_container_exists)

if [ -z "$CONTAINER_ID" ]; then
  CONTAINER_ID=$(run_new_container)
  echo "new container started: $CONTAINER_ID"
else
  IS_RUNNING=$(docker ps -q -f name=${CONTAINER_NAME})
  if [ -z "$IS_RUNNING" ]; then
    echo "start existing container... $CONTAINER_NAME"
    docker start ${CONTAINER_NAME}
    echo "docker exec in ...${CONTAINER_NAME}"
    docker exec -it "$CONTAINER_NAME" bash
  else
    echo "container is already running: $CONTAINER_NAME"
  fi
fi
