import { SVG, Rect } from '@wordpress/primitives';
import { Icon, menu } from '@wordpress/icons';

export default function OverlayMenuIcon( { icon } ) {
  return (
    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
      {icon === 'menu' ? (
        <><Icon icon={menu} /><span style={{ marginLeft: '8px' }}>Menu</span></>
      ) : (
        <SVG
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          width="24"
          height="24"
          aria-hidden="true"
          focusable="false"
        >
          <Rect x="4" y="7.5" width="16" height="1.5" />
          <Rect x="4" y="15" width="16" height="1.5" />
        </SVG>
      )}
    </div>
  );
}
