// Exact vertex and fragment shaders extracted from Motion.dev hero backdrop (LabIdentityField)

export const sphereVertexShader = /* glsl */ `
precision highp float;
attribute vec3 aPosition;
attribute float aTip;
attribute vec4 aColour;
uniform vec2 uSize;
uniform vec2 uRotation;
uniform vec3 uPointer;
uniform vec4 uImpacts[4];
uniform vec3 uHitDirections[4];
uniform float uDebris;
uniform float uCloud;
uniform vec4 uBurst;
uniform vec3 uBurstDirection;
uniform vec2 uBurstRotation;
uniform vec2 uBurstSpin;
uniform float uOuterPulse;
uniform vec2 uEnter;
uniform float uTime;
uniform float uOrb;
uniform float uOrdered;
uniform float uSpringWave[64];
uniform float uLines;
uniform float uDpr;
uniform vec4 uSettings;
uniform float uBlur;
uniform float uNoisePulse;
uniform float uShell;
uniform vec3 uShade;
uniform vec3 uLight;
uniform vec3 uImpact;
uniform vec3 uSweepShade;
uniform vec3 uSweepLight;
uniform float uSweep;
uniform float uDotSize;
uniform float uDotBrightness;
uniform float uGrades;
uniform float uZoom;
uniform vec3 uGradeMap;
uniform float uFrames;
uniform float uFrameState[40];
uniform vec3 uFramePulse;
uniform float uBurstFrame;
uniform vec3 uGradeColours[6];
uniform float uSheet;
varying vec3 vColour;
varying float vAlpha;
varying float vBlur;

vec3 gradeAt(float t, float cyclic) {
  float f = cyclic > 0.5 ? fract(t) * 6.0 : clamp(t, 0.0, 1.0) * 5.0;
  float index = floor(f);
  float next = mod(index + 1.0, 6.0);
  vec3 a = uGradeColours[0];
  vec3 b = uGradeColours[0];
  for (int i = 0; i < 6; i++) {
    if (float(i) == index) a = uGradeColours[i];
    if (float(i) == next) b = uGradeColours[i];
  }
  vec3 linear = mix(pow(a, vec3(2.2)), pow(b, vec3(2.2)), fract(f));
  return pow(linear, vec3(1.0 / 2.2));
}

void main() {
  vBlur = 0.0;
  vec3 p = aPosition;
  // Each point's random seed comes from its rest position, so it never
  // flickers while the frames tunnel swells a ring.
  float seed = fract(sin(dot(aPosition.xy, vec2(127.1, 311.7))) * 43758.5453);
  // The frames tunnel: this point's frame, its state (0 good, 0.5 OK, 1
  // dropped), and the travelling pulse. uFramePulse is (origin, distance
  // travelled each way, strength). 40 frames, 1.25 either side, mirror
  // FRAME_COUNT and FRAME_LENGTH. A dropped ring swells by half again.
  float frameIndex = -1.0;
  float frameDrop = 0.0;
  float framePulse = 0.0;
  if (uFrames > 0.5) {
    frameIndex = floor((aPosition.x / 1.25 * 0.5 + 0.5) * 39.0 + 0.5);
    for (int i = 0; i < 40; i++) if (float(i) == frameIndex) frameDrop = uFrameState[i];
    float gap = abs(aPosition.x - uFramePulse.x) - uFramePulse.y;
    framePulse = exp(-gap * gap / 0.01) * uFramePulse.z;
    p.yz *= mix(1.0, 1.47, frameDrop) * (1.0 + framePulse * 0.04);
  }
  if (uOrb > 0.5) {
    vec2 rotation = uDebris > 0.5 ? uBurstRotation : uRotation;
    float c = cos(rotation.x), s = sin(rotation.x);
    p.xz = mat2(c, -s, s, c) * p.xz;
    c = cos(rotation.y); s = sin(rotation.y);
    p.yz = mat2(c, -s, s, c) * p.yz;
    // The tunnel's axis after the same turn, for rings that burst outwards.
    vec3 axis = vec3(cos(rotation.x), 0.0, -sin(rotation.x));
    axis.yz = mat2(c, -s, s, c) * axis.yz;
    float ripple = sin(p.x * 11.0 + p.y * 7.0 + uTime * 0.7) * 0.006;
    vec2 mouse = uPointer.xy - vec2(uSize.x * 0.53, uSize.y * 0.47);
    mouse.y *= -1.0;
    float shock = 0.0;
    float blush = 0.0;
    float debrisAlpha = 0.0;
    float flight = 0.0;
    for (int i = 0; i < 4; i++) {
      vec4 impact = uImpacts[i];
      float age = max(0.0, uTime - impact.z);
      // Angular distance on the sphere keeps the wave attached during rotation.
      float distance = acos(clamp(dot(aPosition, uHitDirections[i]), -1.0, 1.0));
      float phase = distance - age * 1.9;
      float envelope = (1.0 - exp(-age * 45.0)) * exp(-age * 1.15) * impact.w;
      float band = exp(-phase * phase / 0.055);
      if (uOrdered > 0.5) {
        float localAge = age - distance / 1.9;
        float sampleTime = clamp(localAge * 24.0, 0.0, 63.0);
        int sampleIndex = int(floor(sampleTime));
        int nextIndex = int(min(floor(sampleTime) + 1.0, 63.0));
        float wave = mix(uSpringWave[sampleIndex], uSpringWave[nextIndex], fract(sampleTime));
        wave *= step(0.0, localAge) * (1.0 - step(2.625, localAge)) * impact.w;
        shock += wave;
        blush += abs(wave);
      } else {
        shock += cos(phase * 15.0) * band * envelope;
        blush += band * envelope;
      }

    }
    // The frames tunnel answers clicks with a pulse instead of a wave.
    shock = clamp(shock, -1.0, 1.0) * (1.0 - uFrames);
    blush *= 1.0 - uFrames;
    blush = 1.0 - exp(-blush);
    float noise = sin(p.x * 19.0 + p.z * 13.0 + uTime * 1.2)
      * sin(p.y * 17.0 - p.z * 11.0 + uTime * 0.9);
    noise = noise * 0.65 + sin(seed * 73.0 + uTime * 1.5) * 0.35;
    vec2 hoverOffset = p.xy * min(uSize.x * 0.29, uSize.y * 0.275) * uZoom - mouse;
    float hover = exp(-dot(hoverOffset, hoverOffset) / 6500.0) * uPointer.z
      * smoothstep(-0.1, 0.4, p.z);
    float radius = 1.0 + ripple + noise * uSettings.y + shock * 0.13
      - hover * 0.09;
    // Fibres bend towards an off-centre core, rather than forming a rigid shell.
    vec3 surface = p;
    float strand = 0.5 + 0.5 * sin(seed * 51.0);
    float twist = (1.0 - aTip) * (0.24 + strand * 0.22);
    p.xy = mat2(cos(twist), -sin(twist), sin(twist), cos(twist)) * p.xy;
    p *= radius * mix(0.38 + strand * 0.18, 1.0, aTip);
    p.xy += vec2(0.30, -0.10) * (1.0 - aTip);
    // A soft patch travels around the silhouette once a minute.
    float dustAngle = 0.6 + uTime * 0.105;
    vec2 dustDirection = vec2(cos(dustAngle), sin(dustAngle));
    float dustPatch = smoothstep(0.55, 0.95, dot(surface.xy, dustDirection))
      * (1.0 - smoothstep(0.2, 0.7, abs(surface.z)));
    float dust = smoothstep(0.62, 1.0, seed) * dustPatch * (1.0 - uFrames);
    p += normalize(surface) * (dust * (0.10 + 0.15 * sin(seed * 40.0 + uTime * 0.4)));
    p.xy += vec2(-dustDirection.y, dustDirection.x) * dust * sin(seed * 65.0) * 0.18;
    if (uShell > 0.5) {
      // Keep the same spherical surface and deformation at a larger radius.
      p *= uSettings.w * (1.0 - uOuterPulse * 0.16);
    } else {
      p *= 1.0 - uNoisePulse * 0.42;
    }
    if (uCloud > 0.5) {
      // A second layer fills the hovered patch with fine, gently lifted particles.
      p = surface * (radius + 0.015 + seed * 0.05) * (1.0 - uNoisePulse * 0.42);
      p.xy += vec2(sin(seed * 93.0), cos(seed * 71.0)) * 0.018;
    }
    if (uDebris > 0.5) {
      // Every burst has its own seed and launch orientation, independent of later hits.
      flight = max(0.0, uTime - uBurst.x);
      seed = fract(sin(seed * 713.0 + uBurst.y * 97.0) * 43758.5453);
      float distance = acos(clamp(dot(aPosition, uBurstDirection), -1.0, 1.0));
      debrisAlpha = exp(-distance * distance / 0.16)
        * (1.0 - exp(-flight * 30.0)) * (1.0 - smoothstep(1.2, uBurst.z, flight));
      vec3 tangent = normalize(cross(surface, vec3(0.3, 1.0, 0.2)));
      p = surface * (1.0 + flight * (0.12 + seed * 0.38) * mix(0.3, 1.0, uBurst.w))
        + tangent * flight * sin(seed * 91.0) * 0.22;
      // Released particles keep the tangential speed of their launch point.
      vec3 spinVelocity = cross(vec3(-uBurstSpin.y, uBurstSpin.x, 0.0), surface);
      p += spinVelocity * flight * 0.45;
      p.y += (1.0 - uBurst.w) * flight * 0.10 - uBurst.w * flight * flight * 0.025;
      if (uFrames > 0.5) {
        // A flipped frame's ring sheds particles straight out from the
        // tunnel's axis, drifting a little along it.
        vec3 radial = surface - axis * aPosition.x;
        p = surface + radial * flight * (0.25 + seed * 0.6) + axis * sin(seed * 91.0) * flight * 0.04;
        debrisAlpha = 0.6 * step(abs(frameIndex - uBurstFrame), 0.5)
          * (1.0 - exp(-flight * 30.0)) * (1.0 - smoothstep(0.4, uBurst.z, flight));
      }
    }
    float entrance = uShell > 0.5 ? uEnter.y : uEnter.x;
    p *= mix(0.78, 1.0, entrance);
    float scale = min(uSize.x * 0.29, uSize.y * 0.275) * uZoom;
    vec2 pixel = vec2(uSize.x * 0.53, uSize.y * 0.47) + p.xy * vec2(scale, -scale);
    gl_Position = vec4(pixel / uSize * vec2(2.0, -2.0) + vec2(-1.0, 1.0), 0.0, 1.0);
    
    // A flat sheet (the wave) has no rim: lit edge-on it would draw one
    // bright line where it crosses the view. It shades as a gradient
    // along its length instead.
    float edge = pow(max(1.0 - abs(surface.z), 0.0), 3.0) * (1.0 - uSheet);
    float lighting = clamp(0.52 - surface.x * 0.48 + surface.y * 0.32, 0.08, 1.0);
    lighting = mix(lighting, 0.12 + 0.88 * smoothstep(-1.1, 1.1, -aPosition.x), uSheet * 0.75);
    // Grades stay evenly lit, so no band falls into shadow.
    lighting = mix(lighting, 0.8, uGrades * 0.75);
    vColour = mix(uShade, uLight, lighting);
    // A two-colour tone sweeps to its second pair from top left to bottom
    // right of the screen, so the gradient holds still while the orb turns.
    vColour = mix(vColour, mix(uSweepShade, uSweepLight, lighting), uSweep * clamp(0.25 + (p.x - p.y) * 0.5, 0.0, 1.0));
    if (uGrades > 0.5) {
      // MotionScore's grades, S to F and back, blended round the front view.
      // uGradeMap is (mode, low, high): which measure of the point picks
      // its grade, and the range that runs S to F (GRADE_MAPS).
      float mode = uGradeMap.x;
      float measure = mode < 0.5 ? 0.0
        : mode < 1.5 ? aPosition.x
        : mode < 2.5 ? length(aPosition)
        : mode < 3.5 ? length(aPosition.yz)
        : aPosition.y;
      float turn = (measure - uGradeMap.y) / (uGradeMap.z - uGradeMap.y);
      if (mode < 0.5) turn = fract(atan(aPosition.x, aPosition.y) / 6.2831853 + 1.0);
      vec3 colour = gradeAt(turn, mode < 0.5 ? 1.0 : 0.0);
      vColour = colour * mix(0.72, 1.08, lighting);
      // Good frames are rind green, OK frames blueberry and dropped frames
      // watermelon red; the pulse lights each ring as it passes.
      if (uFrames > 0.5) vColour = mix(mix(mix(uGradeColours[1], uGradeColours[2], min(frameDrop * 2.0, 1.0)), uGradeColours[5], max(frameDrop * 2.0 - 1.0, 0.0)) * mix(0.72, 1.08, lighting), vec3(0.95, 1.0, 0.95), framePulse * 0.3);
    }
    // A member's photo: its points take their pixel's colour, lit as the
    // tones are, from a dark shade of it to a pale light. Alpha 0
    // everywhere else.
    vColour = mix(vColour, mix(aColour.rgb * 0.42, mix(aColour.rgb, vec3(1.0), 0.22), lighting), step(0.5, aColour.a));
    vec3 impactColour = uImpact;
    if (uDebris < 0.5) vColour = mix(vColour, impactColour, blush * 0.45);
    float front = smoothstep(-0.1, 0.65, surface.z);
    float mottling = 0.65 + 0.35 * sin(surface.x * 9.0 + surface.z * 4.0)
      * cos(surface.y * 8.0 - surface.z * 5.0);
    float rimLight = edge * (0.95 + lighting * lighting * 0.55);
    vAlpha = (0.035 + rimLight + front * (0.16 + mottling * 0.25))
      * mix(lighting, 0.62 + lighting * 0.38, front * 0.65);
    vAlpha *= mix(0.45, 1.0, strand);
    vAlpha *= uLines > 0.5 ? (0.016 + aTip * 0.022) * (1.0 - dust) : 1.65 * step(0.999, aTip);
    // Without a rim the sheet would barely show, so it draws evenly bright
    // along its gradient, its lit end near full strength.
    if (uSheet > 0.5) vAlpha = (0.45 + 0.65 * lighting) * step(0.999, aTip);
    vAlpha += uLines < 0.5 ? dust * 0.11 * step(0.999, aTip) : 0.0;
    vAlpha *= uSettings.x;
    gl_PointSize = (1.3 + front * (0.2 + seed * 0.4) + edge * (1.5 + strand * 2.5)) * (1.0 - dust * 0.45) * uDpr;
    if (uShell > 0.5) {
      // A stable random subset covers the whole sphere, not just its rim.
      float shellSeed = fract(sin(dot(aPosition, vec3(93.7, 247.3, 157.9))) * 15731.743);
      float density = step(0.76, shellSeed);
      vAlpha = (0.18 + max(surface.z, 0.0) * 0.55 + edge * 0.16)
        * lighting * uSettings.x * uSettings.z * density;
      float coreSize = (1.5 + strand * 1.5) * uDpr;
      // Only points in front of the focus plane soften as they approach us.
      vBlur = uBlur * smoothstep(0.55, 1.3, p.z);
      gl_PointSize = coreSize + vBlur * uDpr;
      vColour = mix(vColour, vec3(1.0, 0.97, 0.91), 0.16);
      vAlpha *= pow(coreSize / gl_PointSize, 1.2);
    }
    if (uCloud > 0.5) {
      vAlpha = hover * hover * (0.3 + seed * 0.5) * uSettings.x;
      gl_PointSize = (1.2 + seed * 1.4) * uDpr;
    }
    if (uDebris > 0.5) {
      vAlpha = debrisAlpha * uBurst.w * step(mix(0.97, 0.86, uBurst.w), seed) * (0.35 + seed * 0.5) * uSettings.x;
      gl_PointSize = (1.2 + seed * 1.6) * uDpr;
    }
    vAlpha *= entrance * (1.0 + blush * 0.6);
    // Keep a small light response alongside the surface deformation.
    vec2 hoverDelta = p.xy * scale - mouse;
    float hoverLight = exp(-dot(hoverDelta, hoverDelta) / 9000.0) * uPointer.z;
    vAlpha *= 1.0 + hoverLight * front * 0.9;
    float lowerRightShadow = smoothstep(-0.25, 0.65, surface.x)
      * smoothstep(-0.25, 0.65, -surface.y);
    // Grades keep every band readable, so their shadow is lighter.
    vAlpha *= 1.0 - lowerRightShadow * mix(0.92, 0.2, max(uGrades, uSheet));
    if (uDebris < 0.5) vColour = mix(vColour, vec3(1.0, 0.95, 0.72), hoverLight * 0.12);
    vAlpha *= 1.0 + framePulse * 0.45;
    if (uSheet > 0.5 && uShell < 0.5 && uCloud < 0.5 && uDebris < 0.5) gl_PointSize = (1.7 + seed * 0.9) * uDpr;
    gl_PointSize *= uDotSize;
    vAlpha *= uDotBrightness;
    if (aColour.a > 0.9 && uShell < 0.5 && uCloud < 0.5 && uDebris < 0.5) {
      // A photo's points skip the shell's mottling and rim, so the picture
      // reads, but keep its lighting, shadow, hover light and impacts.
      // Fine dots, as the logo's, held near full strength so the picture
      // reads; the shadow only softens it.
      vAlpha = min(1.0, uSettings.x * entrance * mix(0.7, 1.0, lighting)
        * (1.0 - lowerRightShadow * 0.45) * (1.0 + hoverLight * front * 0.6) * (1.0 + blush * 0.6) * uDotBrightness);
      // The photo's own colour, lit but never dimmed below its value.
      vColour = aColour.rgb * mix(0.92, 1.12, lighting);
    }
  } else {
    vec2 pixel = vec2(uSize.x * 0.69, uSize.y * 0.58) + p.xy * min(uSize.x * 0.54, 900.0);
    float wave = sin(p.x * 18.0 + uTime * 0.5) * cos(p.y * 14.0 - uTime * 0.3);
    float proximity = exp(-dot(pixel - uPointer.xy, pixel - uPointer.xy) / 18000.0) * uPointer.z;
    pixel.y += wave * 6.0 + proximity * sin(p.x * 35.0 + uTime * 3.0) * 10.0;
    gl_Position = vec4(pixel / uSize * vec2(2.0, -2.0) + vec2(-1.0, 1.0), 0.0, 1.0);
    float quiet = smoothstep(0.22, 0.62, pixel.x / uSize.x);
    vColour = vec3(0.94, 0.94, 0.91);
    vAlpha = (p.z > 0.5 ? 0.26 + wave * 0.1 : 0.018) * quiet + proximity * 0.12;
    gl_PointSize = (p.z > 0.5 ? 2.0 + wave * 0.5 : 1.0) * uDpr;
  }
}`;

export const sphereFragmentShader = /* glsl */ `
precision highp float;
uniform float uLines;
varying vec3 vColour;
varying float vAlpha;
varying float vBlur;
void main() {
  float alpha = vAlpha;
  if (uLines < 0.5) {
    float d = length(gl_PointCoord - 0.5);
    float sharp = 1.0 - smoothstep(0.25, 0.5, d);
    float soft = exp(-d * d * 18.0) * (1.0 - smoothstep(0.35, 0.5, d));
    alpha *= mix(sharp, soft, min(vBlur / 3.0, 1.0));
  }
  gl_FragColor = vec4(vColour * alpha, alpha);
}`;
